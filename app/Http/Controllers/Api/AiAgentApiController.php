<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Region;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiAgentApiController extends Controller
{
    /**
     * Get all books with full details (id, title, description, author, price, discount, availability, genre, etc.).
     */
    public function books(): JsonResponse
    {
        $books = Book::with('genre:id,ar_name,fr_name,en_name')
            ->withCount('likes')
            ->latest()
            ->get()
            ->map(fn (Book $book) => $this->formatBook($book));

        return response()->json([
            'success' => true,
            'count' => $books->count(),
            'data' => $books,
        ]);
    }

    /**
     * Get all delivery regions with id, delivery availability (enabled), Arabic/French names, and desk/home prices.
     */
    public function regions(): JsonResponse
    {
        $regions = Region::orderBy('id')
            ->get()
            ->map(fn (Region $region) => [
                'id' => $region->id,
                'ar_name' => $region->ar_name,
                'fr_name' => $region->fr_name,
                'enabled' => (bool) $region->enabled,
                'stop_desk' => (int) $region->stop_desk,
                'a_domicile' => (int) $region->a_domicile,
            ]);

        return response()->json([
            'success' => true,
            'count' => $regions->count(),
            'data' => $regions,
        ]);
    }

    /**
     * Get all genres/categories along with the books belonging to each genre.
     */
    public function genres(): JsonResponse
    {
        $genres = Genre::with(['books' => fn ($query) => $query->withCount('likes')->latest()])
            ->withCount('books')
            ->orderBy('id')
            ->get()
            ->map(fn (Genre $genre) => [
                'id' => $genre->id,
                'ar_name' => $genre->ar_name,
                'fr_name' => $genre->fr_name,
                'en_name' => $genre->en_name,
                'books_count' => $genre->books_count,
                'books' => $genre->books->map(fn (Book $book) => $this->formatBook($book, false))->values(),
            ]);

        return response()->json([
            'success' => true,
            'count' => $genres->count(),
            'data' => $genres,
        ]);
    }

    /**
     * Get top 10 reviews (by upvotes) for a given book ID.
     * Returns an empty list [] if no reviews exist.
     */
    public function bookReviews(Request $request, ?int $bookId = null): JsonResponse
    {
        $resolvedBookId = $bookId ?? $request->input('book_id') ?? $request->input('id');

        if (! $resolvedBookId || ! Book::whereKey($resolvedBookId)->exists()) {
            return response()->json([
                'success' => true,
                'book_id' => $resolvedBookId ? (int) $resolvedBookId : null,
                'count' => 0,
                'data' => [],
            ]);
        }

        $reviews = Review::with('user:id,name,role')
            ->withCount('upvotes')
            ->where('book_id', $resolvedBookId)
            ->where('published', true)
            ->orderByDesc('upvotes_count')
            ->latest()
            ->limit(10)
            ->get()
            ->map(fn (Review $review) => [
                'id' => $review->id,
                'book_id' => (int) $review->book_id,
                'user_name' => $review->user?->name,
                'is_admin_review' => $review->user?->role === 1,
                'review' => $review->review,
                'upvotes_count' => (int) $review->upvotes_count,
                'edited' => (bool) $review->edited,
                'created_at' => $review->created_at?->toISOString(),
            ])
            ->values();

        return response()->json([
            'success' => true,
            'book_id' => (int) $resolvedBookId,
            'count' => $reviews->count(),
            'data' => $reviews->all(),
        ]);
    }

    /**
     * Format a book model into a consistent array for the AI agent.
     */
    private function formatBook(Book $book, bool $includeGenre = true): array
    {
        $payload = [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'description' => $book->description,
            'price' => (int) $book->price,
            'discount' => (int) $book->discount,
            'effective_price' => (int) ($book->discount == 0 ? $book->price : $book->discount),
            'quantity' => (int) $book->quantity,
            'available' => $book->quantity > 0,
            'bestseller' => (bool) $book->bestseller,
            'bookshelf' => (bool) $book->bookshelf,
            'likes_count' => (int) ($book->likes_count ?? 0),
            'genre_id' => (int) $book->genre_id,
            'image_url' => asset('uploads/'.$book->image_url),
        ];

        if ($includeGenre && $book->relationLoaded('genre') && $book->genre) {
            $payload['genre'] = [
                'id' => $book->genre->id,
                'ar_name' => $book->genre->ar_name,
                'fr_name' => $book->genre->fr_name,
                'en_name' => $book->genre->en_name,
            ];
        }

        return $payload;
    }
}
