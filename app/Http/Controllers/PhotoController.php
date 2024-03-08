<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class PhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:10240', // for example, allowing max 10MB
            'caption' => 'nullable|string|max:255',
        ]);

        $user = auth()->user(); // Get the authenticated user
        $path = $request->file('photo')->store('users_photo', 'public'); // Save the photo in the storage/app/public/users_photo directory

        $photo = new Photo();
        $photo->user_id = $user->id;
        $photo->caption = $request->caption;

        // Here we are using the Storage facade to get the URL
        $photoUrl = \Illuminate\Support\Facades\Storage::url($path);

        $photo->image_path = $photoUrl; // Save the full URL to the image_path
        $photo->save();

        return response()->json([
            'message' => 'Photo uploaded successfully',
            'photo' => $photo,
        ], 201);
    }
    public function index()
    {
        // Fetch all photos from the database
        $photos = Photo::all();

        // Add full URL to each photo
        // foreach ($photos as $photo) {
        //     $photo->full_path = Storage::url($photo->image_path);
        // }

        // Return the photos with full URLs in the response
        return response()->json([
            'message' => 'All photos retrieved successfully',
            'photos' => $photos
        ], 200);
    }
}
