<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// api.php
Route::post('login', [UserController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::apiResource('video', VideosController::class);
});

// Public routes
Route::get('videos', [VideosController::class, 'index']);
Route::get('videos/{id}', [VideosController::class, 'show']);
Route::get('categories', [CategoryController::class, 'index']);



Route::fallback(function () {
    return response()->json([
        'message' => 'Route not found',
    ], 404);
})->middleware('api'); // Apply the same middleware group as your API routes
