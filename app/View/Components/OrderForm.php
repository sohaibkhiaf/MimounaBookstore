<?php

namespace App\View\Components;

use App\Models\Order;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OrderForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?Order $order = null,
        public string $action,
    )
    {  }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.order-form');
    }
}
