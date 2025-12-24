<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Book $book)
    {
        $book = $book->withCount(['likes' => fn($q) => $q->where('user_id' , '=', auth()->user()->id ?? -1)])->find($book->id);

        $reviews = Review::withCount('upvotes')->withCount(['upvotes as upvoted' => fn($query) => $query->where('user_id' , '=' , auth()->user()->id ?? -1)])
            ->where('published', true)->where('book_id' , '=' , $book->id)->latest()->paginate(20);

        return view('browse/reviews/index' , ['book' => $book , 'reviews' => $reviews]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        return view('browse/reviews/create' , ['book' => $book]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        if(request()->user()->email_verified_at === null){
            return redirect()->back()->with('error', __('messages.error_require_verification'));
        }

        if(request()->user()->banned){
            return redirect()->back()->with('error', __('messages.error_banned_from_reviewing'));
        }

        $data = request()->validate([
            'review' => 'required|string|max:2048',
        ]);

        $published = 0;
        if (request()->user()->role === 1){
            $published = 1;
        }

        request()->user()->reviews()->create([
            'review' => $data['review'],
            'book_id' => $book->id,
            'published' => $published,
        ]);

        if (request()->user()->role === 1){
            return redirect()->route('reviews.index', ['book' => $book->id])
                ->with('success', __('messages.success_review_added_admin'));
        }else{
            return redirect()->route('reviews.index', ['book' => $book->id])
                ->with('success', __('messages.success_review_added'));
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        if(request()->user()->banned){
            return redirect()->back()->with('error', __('messages.error_banned_from_reviewing'));
        }

        if($review->published === false){
            return redirect()->back()->with('error', __('messages.error_update_unpublished_review'));
        }

        $data = request()->validate([
            'review' => 'required|string|max:2048',
        ]);

        $published = 0;
        if (request()->user()->role === 1){
            $published = 1;
        }

        $review->update([
            'review' => $data['review'],
            'published' => $published,
            'edited' => true,
        ]);

        if(request()->user()->id === $review->user->id){

            if (request()->user()->role === 1){
                return redirect()->route('reviews.index', ['book' => $book->id])
                    ->with('success', __('messages.success_review_updated_admin'));
            }else{
                return redirect()->route('reviews.index', ['book' => $book->id])
                    ->with('success', __('messages.success_review_updated'));
            }



        }else{
            // unauthorized action handling
            abort(401);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book , Review $review)
    {
        if(request()->user()->banned){
            return redirect()->back()->with('error', __('messages.error_banned_from_reviewing'));
        }

        if($review->published === false){
            return redirect()->back()->with('error', __('messages.error_delete_unpublished_review'));
        }

        if(request()->user()->id === $review->user->id){

            $review->delete();

            return redirect()->route('reviews.index', ['book' => $book->id])
            ->with('success', __('messages.success_review_deleted'));
        }else{
            // unauthorized action handling
            abort(401);
        }

    }
}
