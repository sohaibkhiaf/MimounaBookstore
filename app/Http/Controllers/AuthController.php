<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage(Request $request)
    {
        return view('auth/login', [
            'intended' => $request->input('intended'),
            'bid' => $request->input('bid'),
        ]);
    }

    public function login(Request $request)
    {
        $intended = $request->input('intended');
        $bookId = $request->input('bid');

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        [$route, $params] = $this->resolveIntendedRoute($intended, $bookId);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return to_route($route, $params)
                ->with('success', __('messages.success_logged_in'));
        }

        return to_route('auth.loginPage', ['intended' => $intended, 'bid' => $bookId])
            ->with('error', __('messages.error_invalid_credentials'));
    }

    public function registerPage(Request $request)
    {
        return view('auth/register', [
            'regions' => Region::all(),
            'intended' => $request->input('intended'),
            'bid' => $request->input('bid'),
        ]);
    }

    public function register(Request $request)
    {
        $intended = $request->input('intended');
        $bookId = $request->input('bid');

        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'phone' => 'required|size:10',
            'age' => 'required|integer',
            'gender' => 'required|between:0,1',
            'region' => 'required|between:1,58',
            'address' => 'required|string|max:255',
        ]);

        [$route, $params] = $this->resolveIntendedRoute($intended, $bookId);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'region_id' => $data['region'],
            'banned' => false,
        ]);

        event(new Registered($user));

        if (Auth::attempt(['email' => $user->email, 'password' => $data['password']], true)) {
            $request->session()->regenerate();

            return to_route($route, $params)
                ->with('success', __('messages.success_account_created'));
        }

        return to_route('auth.registerPage', ['intended' => $intended, 'bid' => $bookId])
            ->with('error', __('messages.error_unexpected'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('browse.index')
            ->with('success', __('messages.success_logged_out'));
    }

    private function resolveIntendedRoute(?string $intended, mixed $bookId): array
    {
        return match ($intended) {
            'cart' => ['browse.cart', []],
            'wishlist' => ['user.wishlist', []],
            'shop' => ['browse.shop', []],
            'book' => ['browse.book', ['book' => $bookId]],
            default => ['browse.index', []],
        };
    }
}
