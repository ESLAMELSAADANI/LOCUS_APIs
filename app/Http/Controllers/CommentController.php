<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'photo_id' => 'required|exists:photos,id',
            'comment' => 'required|string|max:1000', // Adjust max length as needed
        ]);

        $user = auth()->user();

        $comment = new Comment();
        $comment->photo_id = $request->photo_id;
        $comment->user_id = $user->id;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['message' => 'Comment added successfully', 'comment' => $comment], 201);
    }
}
