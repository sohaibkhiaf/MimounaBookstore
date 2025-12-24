<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class AdminOrders extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $tab,
        public Collection|LengthAwarePaginator $orders,
    )
    { }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-orders');
    }
}
