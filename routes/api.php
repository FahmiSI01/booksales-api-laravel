<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MidtransController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::apiResource('/authors', AuthorController::class);
Route::apiResource('/genres', GenreController::class);
Route::apiResource('/books', BookController::class);
Route::apiResource('/carts', CartController::class);
Route::apiResource('/cart-items', CartItemController::class);
Route::apiResource('/contacts', ContactController::class);
Route::apiResource('/payments', PaymentController::class);
Route::apiResource('/transaction-details', TransactionDetailController::class);

Route::post('/midtrans-callback', [MidtransController::class, 'callback']);

Route::middleware('auth:api')->group(function () {
    // Route::get('/books/{id}', [BookController::class, 'show']);
    Route::apiResource('/transactions', TransactionController::class)->only(['index', 'store', 'show', 'update']);
    Route::post('/midtrans-token', [MidtransController::class, 'getToken']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    // Route::apiResource('/authors', AuthorController::class)->only([ 'update', 'destroy']);
    // Route::apiResource('/genres', GenreController::class)->only([ 'update', 'destroy']);
    // Route::apiResource('/books', BookController::class)->only([ 'update', 'destroy']);
    Route::delete('/transactions/delete-all', [TransactionController::class, 'destroyAll']);
    Route::apiResource('/transactions', TransactionController::class)->only(['destroy']);
    Route::apiResource('/users', UserController::class);
});
