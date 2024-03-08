<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'photo_id' => 'required|exists:photos,id',
        ]);

        $user = auth()->user();
        $photoId = $request->photo_id;

        // Check if the user has already liked the photo
        $like = Like::where('photo_id', $photoId)->where('user_id', $user->id)->first();
        if ($like) {
            return response()->json(['message' => 'You have already liked this photo'], 409);
        }

        $like = new Like();
        $like->photo_id = $photoId;
        $like->user_id = $user->id;
        $like->save();

        return response()->json(['message' => 'Like added successfully'], 201);
    }
}
