<?php

namespace App\View\Components;

use App\Models\Genre;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GenreForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $action,
        public ?Genre $genre = null,
    )
    {  }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.genre-form');
    }
}
