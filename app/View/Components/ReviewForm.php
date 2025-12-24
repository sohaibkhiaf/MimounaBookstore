<?php

namespace App\View\Components;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReviewForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $user,
        public string $action,
        public ?Book $book = null,
        public ?Review $review = null,
    )
    { }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.review-form');
    }
}
