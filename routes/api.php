<?php

use App\Http\Controllers\Api\AiAgentApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AI Agent API Routes
|--------------------------------------------------------------------------
|
| All routes in this file are automatically prefixed with /api by Laravel.
|
*/

Route::get('/books', [AiAgentApiController::class, 'books'])->name('api.books');
Route::get('/regions', [AiAgentApiController::class, 'regions'])->name('api.regions');
Route::get('/genres', [AiAgentApiController::class, 'genres'])->name('api.genres');

// Get top 10 reviews for a specific book (via path param /api/books/{bookId}/reviews or query /api/reviews?book_id=...)
Route::get('/books/{bookId}/reviews', [AiAgentApiController::class, 'bookReviews'])
    ->whereNumber('bookId')
    ->name('api.books.reviews');
Route::get('/reviews', [AiAgentApiController::class, 'bookReviews'])->name('api.reviews');
