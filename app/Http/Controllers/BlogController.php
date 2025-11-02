<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(6);

        $categories = Category::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->load(['category', 'user', 'approvedComments.user']);
        
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        $categories = Category::withCount('posts')->get();

        return view('blog.show', compact('post', 'relatedPosts', 'categories'));
    }

    public function category(Category $category)
    {
        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(6);

        $categories = Category::withCount('posts')->get();

        return view('blog.category', compact('posts', 'categories', 'category'));
    }
}
