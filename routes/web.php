<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;

// --------------------
// Frontend Routes
// --------------------
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/post/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');

// --------------------
// User Registration & Posts
// --------------------
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::resource('user/posts', UserPostController::class)->names('user.posts')->middleware('auth');

// --------------------
// Admin Routes (Protected)
// --------------------
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Posts
    Route::resource('posts', PostController::class)->names('admin.posts');

    // Categories
    Route::resource('categories', CategoryController::class)->names('admin.categories');

    // Comments
    Route::resource('comments', AdminCommentController::class)->names('admin.comments');
    Route::patch('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('admin.comments.approve');
    Route::patch('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('admin.comments.reject');

    // Post approval
    Route::patch('posts/{post}/approve', [PostController::class, 'approve'])->name('admin.posts.approve');
    Route::patch('posts/{post}/reject', [PostController::class, 'reject'])->name('admin.posts.reject');
});

// --------------------
// Authentication Routes
// --------------------
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(auth()->user()->isAdmin() ? '/admin' : '/user/posts');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');
