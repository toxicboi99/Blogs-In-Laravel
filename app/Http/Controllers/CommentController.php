<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
        ]);

        Comment::create([
            'content' => $request->content,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Your comment has been submitted and is awaiting moderation.');
    }
}
