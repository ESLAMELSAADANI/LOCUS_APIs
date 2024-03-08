<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PhotoController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('events', [EventController::class, 'index']);
Route::get('events/{date}', [EventController::class, 'getEventsByDate']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/photos', [PhotoController::class, 'store']);
    Route::get('/photos', [PhotoController::class, 'index']);
    // Other photo routes
    Route::post('/photos/like', [LikeController::class, 'store']);
    Route::post('/photos/comment', [CommentController::class, 'store']);
});
