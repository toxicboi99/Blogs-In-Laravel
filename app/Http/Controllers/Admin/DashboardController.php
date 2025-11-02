<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_categories' => Category::count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'approved_comments' => Comment::where('status', 'approved')->count(),
        ];

        $recent_posts = Post::with(['category', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        $recent_comments = Comment::with(['post', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_comments'));
    }
}
