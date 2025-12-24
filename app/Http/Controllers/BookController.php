<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get params
        $search = request()->input('search');
        $gid = request()->input('gid');
        $filters = request()->only(['search' , 'gid']);

        // fetch books
        $books = Book::filter($filters)->latest()->paginate(20);

        // open view
        return view('admin/books/index', [
            'search' => $search,
            'gid' => $gid,
            'genres' => Genre::all(),
            'books' => $books,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // open view
        return view('admin/books/create' , [ 'genres' => Genre::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate data
        $data = request()->validate([
            'title'=> 'required|string',
            'author'=> 'required|string',
            'description'=> 'required|string',
            'price'=> 'required|integer',
            'discount'=> 'required|integer',
            'quantity'=> 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'genre'=> 'required|integer',
        ]);

        // store image
        $file = request()->file('image');
        $path = $file->store('books' , 'public');

        // create book
        Book::create([
            'title' => $data['title'],
            'author' => $data['author'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount' => $data['discount'],
            'quantity' => $data['quantity'],
            'image_url' => $path,
            'genre_id' => $data['genre'],
            'bestseller' => request()->filled('bestseller'),
            'bookshelf' => request()->filled('bookshelf'),
        ]);

        // return to books view
        return redirect()->route('admin.books', ['locale' => auth()->user()->language])
            ->with('success', __('messages.success_book_added'));
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
    public function edit(Book $book)
    {

        // open edit book & genres view
        return view('admin/books/edit', ['book'=> $book, 'genres' => Genre::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // validate data
        $data = request()->validate([
            'title'=> 'required|string',
            'author'=> 'required|string',
            'description'=> 'required|string',
            'price'=> 'required|integer',
            'discount'=> 'required|integer',
            'quantity'=> 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'genre'=> 'required|integer',
        ]);

        if( !isset($data['image']) ){

            // update book
            $book->update([
                'title' => $data['title'],
                'author' => $data['author'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount' => $data['discount'],
                'quantity' => $data['quantity'],
                'genre_id' => $data['genre'],
                'bestseller' => request()->filled('bestseller'),
                'bookshelf' => request()->filled('bookshelf'),
            ]);
        }else{

            // store image
            $file = request()->file('image');
            $path = $file->store('books' , 'public');

            // delete old image
            if ($book->image_url && Storage::disk('public')->exists($book->image_url)) {
                Storage::disk('public')->delete($book->image_url);
            }

            // update book
            $book->update([
                'title' => $data['title'],
                'author' => $data['author'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discount' => $data['discount'],
                'quantity' => $data['quantity'],
                'image_url' => $path,
                'genre_id' => $data['genre'],
                'bestseller' => request()->filled('bestseller'),
                'bookshelf' => request()->filled('bookshelf'),
            ]);
        }

        // return to books & genres view
        return redirect()->route('admin.books', ['locale' => auth()->user()->language])
            ->with('success',__('messages.success_book_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // delete book
        $book->delete();

        // return to books & genres view
        return redirect()->route('admin.books', ['locale' => auth()->user()->language])
            ->with('success', __('messages.success_book_deleted' , ['book_title' => $book->title]));
    }
}
