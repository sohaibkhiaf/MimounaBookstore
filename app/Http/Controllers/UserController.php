<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tab = $request->input('tab');

        $users = User::withCount([
            'orders as delivered_orders_count' => fn ($q) => $q->where('order_status_id', 3),
            'orders as returned_orders_count' => fn ($q) => $q->where('order_status_id', 5),
        ])
            ->when($tab === 'banned_users', fn ($q) => $q->where('banned', true))
            ->paginate(10)
            ->withQueryString();

        return view('admin/users/index', ['tab' => $tab, 'users' => $users]);
    }
}
