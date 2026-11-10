<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Book $book)
    {
        $book->loadCount([
            'likes' => fn ($q) => $q->where('user_id', auth()->id() ?? -1),
            'likes as total_likes_count',
        ]);

        $reviews = $book->reviews()
            ->with(['user', 'book'])
            ->withUpvotesData()
            ->where('published', true)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('browse/reviews/index', ['book' => $book, 'reviews' => $reviews]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        return view('browse/reviews/create', ['book' => $book]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $user = $request->user();

        if ($user->email_verified_at === null) {
            return back()->with('error', __('messages.error_require_verification'));
        }

        if ($user->banned) {
            return back()->with('error', __('messages.error_banned_from_reviewing'));
        }

        $data = $request->validate([
            'review' => 'required|string|max:2048',
        ]);

        $isAdmin = $user->role === 1;

        $user->reviews()->create([
            'review' => $data['review'],
            'book_id' => $book->id,
            'published' => $isAdmin ? 1 : 0,
        ]);

        return to_route('reviews.index', ['book' => $book->id])
            ->with('success', __($isAdmin ? 'messages.success_review_added_admin' : 'messages.success_review_added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book, Review $review)
    {
        return view('browse/reviews/edit', ['book' => $book, 'review' => $review]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book, Review $review)
    {
        $user = $request->user();

        if ($user->banned) {
            return back()->with('error', __('messages.error_banned_from_reviewing'));
        }

        if (! $review->published) {
            return back()->with('error', __('messages.error_update_unpublished_review'));
        }

        abort_unless($user->id === $review->user_id, 401);

        $data = $request->validate([
            'review' => 'required|string|max:2048',
        ]);

        $isAdmin = $user->role === 1;

        $review->update([
            'review' => $data['review'],
            'published' => $isAdmin ? 1 : 0,
            'edited' => true,
        ]);

        return to_route('reviews.index', ['book' => $book->id])
            ->with('success', __($isAdmin ? 'messages.success_review_updated_admin' : 'messages.success_review_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book, Review $review)
    {
        $user = $request->user();

        if ($user->banned) {
            return back()->with('error', __('messages.error_banned_from_reviewing'));
        }

        if (! $review->published) {
            return back()->with('error', __('messages.error_delete_unpublished_review'));
        }

        abort_unless($user->id === $review->user_id, 401);

        $review->delete();

        return to_route('reviews.index', ['book' => $book->id])
            ->with('success', __('messages.success_review_deleted'));
    }
}
