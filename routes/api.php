<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);
Route::get('/books', [BookController::class, 'index']);

Route::middleware('auth:api')->group(function () {
    Route::get('/books/{id}', [BookController::class, 'show']);
});

Route::middleware('role:admin')->group(function () {
    Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('/books', BookController::class)->only(['store', 'update', 'destroy']);
});

