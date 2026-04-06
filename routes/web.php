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
    $cutoffDate = '2026-04-03 21:00:00';
    $demoUserIds = [1, 2];
    
    $query = App\Models\Live::query();

    // Guests and New users only see REAL data
    $isNew = !Auth::check() || Auth::user()->created_at->isAfter($cutoffDate);
    
    if ($isNew) {
        $query->whereNotIn('user_id', $demoUserIds);
    }

    $topLives = $query->latest()->take(3)->get();
    
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

// Legal Routes
Route::get('/termos-de-uso', function () {
    return view('legal.terms');
})->name('terms');

Route::get('/politica-de-privacidade', function () {
    return view('legal.privacy');
})->name('privacy');

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

    Route::get('/create', function () {
        return view('create-post');
    })->name('post.create');

    // Lives Routes
    Route::get('/lives', [LiveController::class, 'index'])->name('lives');
    Route::get('/lives/create', [LiveController::class, 'create'])->name('live.create');
    Route::post('/lives/store', [LiveController::class, 'store'])->name('live.store');
    Route::get('/lives/{live}', [LiveController::class, 'watch'])->name('live.watch');
    Route::post('/lives/{live}/start', [LiveController::class, 'start'])->name('live.start');
    Route::get('/lives/{live}/status', [LiveController::class, 'status'])->name('live.status');
    Route::post('/lives/{live}/chat', [LiveController::class, 'sendMessage'])->name('live.chat');
    Route::get('/lives/{live}/messages', [LiveController::class, 'getMessages'])->name('live.messages');
    Route::post('/lives/{live}/gift', [LiveController::class, 'sendGift'])->name('live.gift');
    Route::delete('/lives/{live}', [LiveController::class, 'destroy'])->name('live.destroy');
    
    // Placeholder for other features
    Route::get('/stories', function () { return view('stories'); })->name('stories');

    // Download Route
    Route::get('/download/{id}', [DownloadController::class, 'download'])->name('post.download');

    // Chat Routes
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');

    // Purchases Routes
    Route::get('/purchases', [App\Http\Controllers\PurchaseController::class, 'index'])->name('purchases.index');
});
