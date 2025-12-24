<?php

namespace App\View\Components;

use App\Models\Region;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RegionForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Region $region,
    )
    {  }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.region-form');
    }
}
