<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // open create genre view
        return view('admin/genres/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate data
        $data = request()->validate([
            'english-name'=> 'required|string',
            'arabic-name'=> 'required|string',
            'french-name'=> 'required|string',
            'fontawesome'=> 'required|string',
        ]);

        // create genre
        Genre::create([
            'en_name' => $data['english-name'],
            'ar_name' => $data['arabic-name'],
            'fr_name' => $data['french-name'],
            'fa_icon' => $data['fontawesome'],
        ]);

        // open books & genres view
        return redirect()->route('admin.books')
            ->with('success', __('messages.success_genre_added'));
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
    public function edit(Genre $genre)
    {
        // open edit genre view
        return view('admin/genres/edit', ['genre'=> $genre]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        // validate data
        $data = request()->validate([
            'english-name'=> 'required|string',
            'arabic-name'=> 'required|string',
            'french-name'=> 'required|string',
            'fontawesome'=> 'required|string',
        ]);

        // update genre
        $genre->update([
            'en_name' => $data['english-name'],
            'ar_name' => $data['arabic-name'],
            'fr_name' => $data['french-name'],
            'fa_icon' => $data['fontawesome'],
        ]);

        // open books & genres view
        return redirect()->route('admin.books', ['genre_id' => $genre->id])
            ->with('success', __('messages.success_genre_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        // cannot delete default genres
        if($genre->id === 1 || $genre->id === 2){
            return redirect()->route('admin.books')
                ->with('error', __('messages.error_default_genres'));
        }

        // delete genre
        $genre->delete();

        // open books & genres view
        return redirect()->route('admin.books')
            ->with('success', __('messages.success_genre_deleted'));
    }
}
