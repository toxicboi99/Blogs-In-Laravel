<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with(['post', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Comments are typically created from the frontend
        return redirect()->route('admin.comments.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Comments are typically created from the frontend
        return redirect()->route('admin.comments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment->load(['post', 'user']);
        return view('admin.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $comment->update($request->only(['content', 'status']));

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }

    /**
     * Approve a comment
     */
    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return redirect()->back()
            ->with('success', 'Comment approved successfully.');
    }

    /**
     * Reject a comment
     */
    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', 'Comment rejected successfully.');
    }
}
