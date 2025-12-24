<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class VoteController extends Controller
{

    public function upvote(Request $request , Review $review)
    {
        if(!$request->user()->upvotes()->where("review_id", $review->id)->exists()){

            $review->upvotes()->create(['user_id' => $request->user()->id ]);

            return response()->json(['error' => false , 'message'=> __('messages.success_upvote_review')]);
        }else{
            
            return response()->json(['error' => true , 'message'=> __('messages.error_upvote_review')]);
        }
    }

    public function downvote(Request $request , Review $review)
    {
        if($review->upvotes()->where('user_id', $request->user()->id)->delete()){

            return response()->json(['error' => false , 'message'=> __('messages.success_downvote_review')]);
        }else{

            return response()->json(['error' => true , 'message'=> __('messages.error_downvote_review')]);
        }
    }

}
