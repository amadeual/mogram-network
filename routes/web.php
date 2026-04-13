<?php

// Sync Date: 2026-04-06 10:40
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $topLives = App\Models\Live::where('status', 'online')->latest()->take(3)->get();
    
    return view('landing', compact('topLives'));
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/check-username', [AuthController::class, 'checkUsername'])->name('username.check');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Legal & Support Routes
Route::get('/termos-de-uso', function () {
    return view('legal.terms');
})->name('terms');

Route::get('/politica-de-privacidade', function () {
    return view('legal.privacy');
})->name('privacy');

Route::get('/ajuda', function () {
    return view('help.index');
})->name('help');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [FeedController::class, 'index'])->name('dashboard');
    Route::get('/search/users', [App\Http\Controllers\SearchController::class, 'search'])->name('search.users');
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/posts/{post}/like', [FeedController::class, 'toggleLike'])->name('posts.like');
    Route::post('/posts/{post}/comments', [FeedController::class, 'storeComment'])->name('posts.comment');
    Route::post('/posts/{post}/unlock', [FeedController::class, 'unlockPost'])->name('posts.unlock');
    Route::delete('/comments/{comment}', [FeedController::class, 'deleteComment'])->name('comments.delete');

    Route::get('/profile/{username}', [App\Http\Controllers\ProfileController::class, 'show'])->name('creator.profile');
    Route::post('/profile/{user}/follow', [App\Http\Controllers\ProfileController::class, 'toggleFollow'])->name('user.follow');

    // Studio Routes
    Route::get('/studio', [StudioController::class, 'index'])->name('studio.dashboard');
    Route::get('/studio/contents', [StudioController::class, 'content'])->name('studio.content');
    Route::get('/studio/analytics', [StudioController::class, 'analytics'])->name('studio.analytics');
    Route::get('/studio/finance', [StudioController::class, 'finance'])->name('studio.finance');
    Route::get('/studio/finance/withdraw', [StudioController::class, 'withdrawPage'])->name('studio.withdraw_page');
    Route::post('/studio/withdraw', [StudioController::class, 'withdraw'])->name('studio.withdraw');
    Route::get('/studio/create', [StudioController::class, 'create'])->name('studio.create');
    Route::post('/studio/store', [StudioController::class, 'store'])->name('studio.store');
    Route::get('/studio/edit/{post}', [StudioController::class, 'edit'])->name('studio.edit');
    Route::get('/studio/analytics/{post}', [StudioController::class, 'postAnalytics'])->name('studio.post_analytics');
    Route::put('/studio/update/{post}', [StudioController::class, 'update'])->name('studio.update');
    Route::delete('/studio/delete/{post}', [StudioController::class, 'destroy'])->name('studio.delete');
    Route::post('/posts/{post}/view', [StudioController::class, 'incrementView'])->name('posts.view');
    Route::post('/posts/{post}/share', [StudioController::class, 'incrementShare'])->name('posts.share');

    // Settings Routes
    Route::get('/studio/settings', [SettingsController::class, 'index'])->name('studio.settings');
    Route::post('/studio/settings', [SettingsController::class, 'update'])->name('studio.settings.update');
    Route::post('/studio/settings/password', [SettingsController::class, 'updatePassword'])->name('studio.settings.password');

    Route::get('/create', function () {
        return view('create-post');
    })->name('post.create');

    // Lives Routes
    Route::get('/lives', [LiveController::class, 'index'])->name('lives');
    Route::get('/lives/create', [LiveController::class, 'create'])->name('live.create');
    Route::post('/lives/store', [LiveController::class, 'store'])->name('live.store');
    Route::get('/lives/{live}/edit', [LiveController::class, 'edit'])->name('live.edit');
    Route::put('/lives/{live}/update', [LiveController::class, 'update'])->name('live.update');
    Route::get('/lives/{live}', [LiveController::class, 'watch'])->name('live.watch');
    Route::post('/lives/{live}/start', [LiveController::class, 'start'])->name('live.start');
    Route::get('/lives/{live}/status', [LiveController::class, 'status'])->name('live.status');
    Route::post('/lives/{live}/chat', [LiveController::class, 'sendMessage'])->name('live.chat');
    Route::get('/lives/{live}/messages', [LiveController::class, 'getMessages'])->name('live.chat.messages');
    Route::post('/lives/{live}/gift', [LiveController::class, 'sendGift'])->name('live.gift');
    Route::post('/lives/{live}/like', [LiveController::class, 'toggleLike'])->name('live.like');
    Route::post('/lives/{live}/pause', [LiveController::class, 'togglePause'])->name('live.pause');
    Route::post('/lives/{live}/media', [LiveController::class, 'toggleMedia'])->name('live.media');
    Route::post('/lives/{live}/buy', [LiveController::class, 'buyAccess'])->name('live.buy');
    Route::delete('/lives/{live}', [LiveController::class, 'destroy'])->name('live.destroy');
    
    // Placeholder for other features
    // Stories Routes
    Route::get('/stories', [App\Http\Controllers\StoryController::class, 'index'])->name('stories');
    Route::post('/stories/store', [App\Http\Controllers\StoryController::class, 'store'])->name('stories.store');
    Route::post('/stories/{story}/view', [App\Http\Controllers\StoryController::class, 'markAsViewed'])->name('stories.view');
    Route::post('/stories/{story}/gift', [App\Http\Controllers\StoryController::class, 'sendGift'])->name('stories.gift');
    Route::post('/stories/{story}/message', [App\Http\Controllers\StoryController::class, 'sendMessage'])->name('stories.message');

    // Notifications Routes
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Download Route
    Route::get('/download/{id}', [DownloadController::class, 'download'])->name('post.download');

    // Chat Routes
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/{user}/gift', [ChatController::class, 'sendGift'])->name('chat.gift');

    // Admin Panel Routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{id}', [App\Http\Controllers\AdminController::class, 'showUser'])->name('admin.users.show');
        Route::post('/users/{id}/toggle/{action}', [App\Http\Controllers\AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle');
        Route::post('/users/{id}/reset-password', [App\Http\Controllers\AdminController::class, 'resetUserPassword'])->name('admin.users.reset_password');
        Route::get('/categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/withdrawals', [App\Http\Controllers\AdminController::class, 'withdrawals'])->name('admin.withdrawals');
        Route::get('/deposits', [App\Http\Controllers\AdminController::class, 'deposits'])->name('admin.deposits');
        Route::get('/gifts', [App\Http\Controllers\AdminController::class, 'gifts'])->name('admin.gifts');
        Route::post('/gifts/{id}', [App\Http\Controllers\AdminController::class, 'updateGift'])->name('admin.gifts.update');
        Route::get('/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [App\Http\Controllers\AdminController::class, 'updateSettings'])->name('admin.settings.update');
    });

    // Purchases Routes
    Route::get('/purchases', [App\Http\Controllers\PurchaseController::class, 'index'])->name('purchases.index');

    // Communities Routes
    Route::get('/communities/explore', [App\Http\Controllers\CommunityController::class, 'index'])->name('communities.explore');
    Route::get('/communities/my', [App\Http\Controllers\CommunityController::class, 'myCommunities'])->name('communities.my');
    Route::post('/communities/store', [App\Http\Controllers\CommunityController::class, 'store'])->name('communities.store');
    Route::get('/communities/{community:slug}', [App\Http\Controllers\CommunityController::class, 'show'])->name('communities.show');
    Route::get('/communities/{community:slug}/dashboard', [App\Http\Controllers\CommunityController::class, 'dashboard'])->name('communities.dashboard');
    Route::get('/communities/{community:slug}/members', [App\Http\Controllers\CommunityController::class, 'members'])->name('communities.members');
    Route::post('/communities/{community:slug}/subscribe', [App\Http\Controllers\CommunityController::class, 'subscribe'])->name('communities.subscribe');
    Route::post('/communities/{community:slug}/posts', [App\Http\Controllers\CommunityController::class, 'storePost'])->name('communities.posts.store');
    Route::put('/communities/{community:slug}/settings', [App\Http\Controllers\CommunityController::class, 'updateSettings'])->name('communities.settings.update');
});
