<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::where('user_id', auth()->id())
            ->with(['category'])
            ->latest()
            ->paginate(10);

        return view('user.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = auth()->id();
        $data['status'] = 'draft';
        $data['approval_status'] = 'pending';

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('user.posts.index')
            ->with('success', 'Your post has been submitted and is awaiting admin approval.');
    }

    public function show(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->load(['category', 'user']);
        return view('user.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        if ($post->approval_status === 'approved') {
            return redirect()->route('user.posts.index')
                ->with('error', 'Cannot edit approved posts.');
        }

        $categories = Category::all();
        return view('user.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        if ($post->approval_status === 'approved') {
            return redirect()->route('user.posts.index')
                ->with('error', 'Cannot edit approved posts.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['approval_status'] = 'pending'; // Reset approval status when edited

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('user.posts.index')
            ->with('success', 'Your post has been updated and is awaiting admin approval.');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        if ($post->approval_status === 'approved') {
            return redirect()->route('user.posts.index')
                ->with('error', 'Cannot delete approved posts. Contact admin.');
        }

        $post->delete();

        return redirect()->route('user.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}