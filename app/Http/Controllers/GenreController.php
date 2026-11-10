<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/genres/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'english-name' => 'required|string',
            'arabic-name' => 'required|string',
            'french-name' => 'required|string',
            'fontawesome' => 'required|string',
        ]);

        Genre::create([
            'en_name' => $data['english-name'],
            'ar_name' => $data['arabic-name'],
            'fr_name' => $data['french-name'],
            'fa_icon' => $data['fontawesome'],
        ]);

        return to_route('admin.books')
            ->with('success', __('messages.success_genre_added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('admin/genres/edit', ['genre' => $genre]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $data = $request->validate([
            'english-name' => 'required|string',
            'arabic-name' => 'required|string',
            'french-name' => 'required|string',
            'fontawesome' => 'required|string',
        ]);

        $genre->update([
            'en_name' => $data['english-name'],
            'ar_name' => $data['arabic-name'],
            'fr_name' => $data['french-name'],
            'fa_icon' => $data['fontawesome'],
        ]);

        return to_route('admin.books', ['genre_id' => $genre->id])
            ->with('success', __('messages.success_genre_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        if (in_array($genre->id, [1, 2], true)) {
            return to_route('admin.books')
                ->with('error', __('messages.error_default_genres'));
        }

        $genre->delete();

        return to_route('admin.books')
            ->with('success', __('messages.success_genre_deleted'));
    }
}
