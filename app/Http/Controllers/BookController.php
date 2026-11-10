<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'gid']);

        return view('admin/books/index', [
            'search' => $request->input('search'),
            'gid' => $request->input('gid'),
            'genres' => Genre::withCount('books')->get(),
            'books' => Book::filter($filters)->latest()->paginate(20)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/books/create', ['genres' => Genre::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'discount' => 'required|integer',
            'quantity' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'genre' => 'required|integer',
        ]);

        $path = $request->file('image')->store('books', 'public');

        Book::create([
            'title' => $data['title'],
            'author' => $data['author'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'quantity' => $data['quantity'],
            'image_url' => $path,
            'genre_id' => $data['genre'],
            'bestseller' => $request->filled('bestseller'),
            'bookshelf' => $request->filled('bookshelf'),
        ]);

        return to_route('admin.books', ['locale' => $request->user()->language])
            ->with('success', __('messages.success_book_added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('admin/books/edit', ['book' => $book, 'genres' => Genre::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'discount' => 'required|integer',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'genre' => 'required|integer',
        ]);

        $attributes = [
            'title' => $data['title'],
            'author' => $data['author'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'quantity' => $data['quantity'],
            'genre_id' => $data['genre'],
            'bestseller' => $request->filled('bestseller'),
            'bookshelf' => $request->filled('bookshelf'),
        ];

        if ($request->hasFile('image')) {
            if ($book->image_url && Storage::disk('public')->exists($book->image_url)) {
                Storage::disk('public')->delete($book->image_url);
            }
            $attributes['image_url'] = $request->file('image')->store('books', 'public');
        }

        $book->update($attributes);

        return to_route('admin.books', ['locale' => $request->user()->language])
            ->with('success', __('messages.success_book_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book)
    {
        $title = $book->title;
        $book->delete();

        return to_route('admin.books', ['locale' => $request->user()->language])
            ->with('success', __('messages.success_book_deleted', ['book_title' => $title]));
    }
}
