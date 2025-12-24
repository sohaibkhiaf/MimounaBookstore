<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Review as ReviewModel;

class Review extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ReviewModel $review,
        public ?User $user = null,
    )
    { }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.review');
    }
}
