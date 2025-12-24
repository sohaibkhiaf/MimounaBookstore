<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function like(Request $request , Book $book)
    {
        if(!$request->user()->likes()->where("book_id", $book->id)->exists()){

            $book->likes()->create(['user_id' => $request->user()->id ]);

            return response()->json(['error' => false , 'message'=> __('messages.success_like_book', ['book_title' => $book->title])]);
        }else{
            
            return response()->json(['error' => true , 'message'=> __('messages.error_like_book', ['book_title' => $book->title])]);
        }
    }

    public function unlike(Request $request , Book $book)
    {
        if($book->likes()->where('user_id', $request->user()->id)->delete()){

            return response()->json(['error' => false , 'message'=> __('messages.success_unlike_book', ['book_title' => $book->title])]);
        }else{

            return response()->json(['error' => true , 'message'=> __('messages.success_unlike_book', ['book_title' => $book->title])]);
        }
    }
}
