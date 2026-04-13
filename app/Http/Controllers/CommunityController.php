<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityPost;
use App\Models\CommunitySubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $query = Community::where('status', 'active')->with(['user'])->withCount(['subscriptions as members_count' => function($q) {
            $q->where('status', 'active');
        }]);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->has('category') && $request->category != 'Todos') {
            $query->where('category', $request->category);
        }

        $communities = $query->latest()->get();
        
        // Split for design: recommendations (e.g. top 3) and the rest
        $recommended = $communities->take(3);
        $allCommunities = $communities; // Keep all for the grid below
        
        return view('communities.explore', compact('communities', 'recommended', 'allCommunities'));
    }

    public function myCommunities()
    {
        $myCommunities = Community::where('user_id', Auth::id())->get();
        
        $subscribedCommunityIds = CommunitySubscription::where('user_id', Auth::id())
            ->where('status', 'active')
            ->pluck('community_id');
            
        $subscribedCommunities = Community::whereIn('id', $subscribedCommunityIds)->get();
        
        return view('communities.my-communities', compact('myCommunities', 'subscribedCommunities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:5|max:250000',
            'avatar' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
        ]);

        $slug = Str::slug($request->name);
        $count = Community::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) $slug = $slug . '-' . ($count + 1);

        $community = new Community();
        $community->user_id = Auth::id();
        $community->name = $request->name;
        $community->slug = $slug;
        $community->description = $request->description;
        $community->category = $request->category;
        $community->price = $request->price;
        $community->has_free_trial = false;
        $community->free_trial_days = 0;

        if ($request->hasFile('avatar')) {
            $community->avatar = $request->file('avatar')->store('communities/avatars', 'public');
        }
        if ($request->hasFile('banner')) {
            $community->banner = $request->file('banner')->store('communities/banners', 'public');
        }

        $community->save();

        return redirect()->route('communities.dashboard', $community->slug)->with('success', 'Comunidade criada!');
    }

    public function show(Request $request, Community $community)
    {
        $hasAccess = Auth::id() === $community->user_id || 
                     CommunitySubscription::where('user_id', Auth::id())
                        ->where('community_id', $community->id)
                        ->where('status', 'active')
                        ->exists();

        if (!$hasAccess) {
            return view('communities.landing', compact('community'));
        }

        $query = CommunityPost::where('community_id', $community->id)->with('user')->latest();

        if ($request->has('type') && $request->type != 'all') {
            $query->where('media_type', $request->type);
        }

        $posts = $query->paginate(15)->appends(['type' => $request->type]);
            
        $onlineMembersCount = CommunitySubscription::where('community_id', $community->id)
            ->where('status', 'active')
            ->count();

        return view('communities.feed', compact('community', 'posts', 'onlineMembersCount'));
    }

    public function dashboard(Community $community)
    {
        if (Auth::id() !== $community->user_id) abort(403);

        $membersCount = CommunitySubscription::where('community_id', $community->id)->count();
        $activeMembersCount = CommunitySubscription::where('community_id', $community->id)->where('status', 'active')->count();
        $revenue = CommunitySubscription::where('community_id', $community->id)->where('status', 'active')->sum('amount');
        
        $pendingApprovals = CommunitySubscription::where('community_id', $community->id)
            ->where('status', 'pending')
            ->with('user')
            ->get();
            
        $recentMembers = CommunitySubscription::where('community_id', $community->id)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
            
        $recentPosts = CommunityPost::where('community_id', $community->id)
            ->latest()
            ->take(2)
            ->get();

        return view('communities.dashboard', compact('community', 'membersCount', 'activeMembersCount', 'revenue', 'pendingApprovals', 'recentMembers', 'recentPosts'));
    }

    public function subscribe(Community $community)
    {
        if (Auth::id() === $community->user_id) {
            return back()->with('error', 'Você é o proprietário desta comunidade.');
        }

        $existing = CommunitySubscription::where('user_id', Auth::id())
            ->where('community_id', $community->id)
            ->where('status', 'active')
            ->first();

        if ($existing) {
            return redirect()->route('communities.show', $community->slug);
        }

        if (Auth::user()->balance < $community->price) {
            return back()->with('error', 'Saldo insuficiente na carteira. Por favor, faça um depósito.');
        }

        DB::transaction(function () use ($community) {
            // Deduct from buyer
            Auth::user()->decrement('balance', $community->price);

            // Create or update subscription
            CommunitySubscription::updateOrCreate(
                ['community_id' => $community->id, 'user_id' => Auth::id()],
                [
                    'amount' => $community->price,
                    'status' => 'active',
                    'expires_at' => now()->addMonth(),
                    'created_at' => now(), // Force update timestamp to show in finance
                ]
            );

            // Note: We don't increment the owner's 'balance' column because the Studio 
            // calculates earnings based on the community_subscriptions table.
        });

        return redirect()->route('communities.show', $community->slug)->with('success', 'Assinatura realizada com sucesso! Bem-vindo à comunidade.');
    }

    public function storePost(Request $request, Community $community)
    {
        $request->validate([
            'content' => 'required|string',
            'media' => 'nullable|file|max:51200',
        ]);

        $post = new CommunityPost();
        $post->community_id = $community->id;
        $post->user_id = Auth::id();
        $post->content = $request->content;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $post->media = $file->store('communities/posts', 'public');
            
            $ext = $file->getClientOriginalExtension();
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) $post->media_type = 'image';
            elseif (in_array($ext, ['mp4', 'mov', 'avi'])) $post->media_type = 'video';
            elseif ($ext == 'pdf') $post->media_type = 'pdf';
            elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) $post->media_type = 'spreadsheet';
        }

        $post->save();

        return back()->with('success', 'Post publicado!');
    }

    public function update(Request $request, Community $community)
    {
        if (Auth::id() !== $community->user_id) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:5|max:250000',
            'free_trial_days' => 'nullable|integer|min:0',
            'avatar' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['name', 'description', 'category', 'price']);
        $data['has_free_trial'] = false;
        $data['free_trial_days'] = 0;

        if ($request->hasFile('avatar')) {
            if ($community->avatar) Storage::disk('public')->delete($community->avatar);
            $data['avatar'] = $request->file('avatar')->store('communities/avatars', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($community->banner) Storage::disk('public')->delete($community->banner);
            $data['banner'] = $request->file('banner')->store('communities/banners', 'public');
        }

        $community->update($data);

        return back()->with('success', 'Comunidade atualizada com sucesso!');
    }
}
