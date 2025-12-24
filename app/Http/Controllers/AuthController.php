<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{

    public function loginPage()
    {
        // get params
        $intended = request()->input('intended');
        $bookId = request()->input('bid');

        // open view
        return view('auth/login' , ['intended' => $intended, 'bid' => $bookId]);
    }

    public function login(Request $request)
    {
        $intended = request()->input('intended');
        $bookId = request()->input('bid');

        // data valiation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // set intended view
        if($intended == 'cart'){ $route = 'browse.cart'; $params = [];}
        elseif($intended == 'wishlist'){ $route = 'user.wishlist'; $params = [];}
        elseif($intended == 'shop'){ $route = 'browse.shop'; $params = []; }
        elseif($intended=='book'){$route='browse.book'; $params=['book'=>$bookId];}
        else{$route = 'browse.index'; $params = [];}

        $credentials = $request->only('email','password');
        $remember = $request->filled('remember');

        if(Auth::attempt($credentials, $remember)){

            return redirect()->route($route , $params)
                ->with('success',__('messages.success_logged_in'));

        }else{
            return redirect()->route('auth.loginPage' , ['intended' => $intended , 'bid' => $bookId])
                ->with('error' , __('messages.error_invalid_credentials'));
        }
    }

    public function registerPage()
    {
        // get params
        $intended = request()->input('intended');
        $bookId = request()->input('bid');

        // open view
        return view('auth/register' , ['regions' => Region::all() , 'intended' => $intended, 'bid' => $bookId]);
    }

    public function register(Request $request)
    {
        // get params
        $intended = request()->input('intended');
        $bookId = request()->input('bid');

        // data validation
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email'=> 'required|email|max:100',
            'password'=> 'required|min:8|confirmed',
            'password_confirmation'=> 'required',
            'phone' => 'required|size:10',
            'age' => 'required|integer',
            'gender' => 'required|between:0,1',
            'region' => 'required|between:1,58',
            'address' => 'required|string|max:255',
        ]);

        // set intended view
        if($intended == 'cart'){ $route = 'browse.cart'; $params = [];}
        elseif($intended == 'wishlist'){ $route = 'user.wishlist'; $params = [];}
        elseif($intended == 'shop'){ $route = 'browse.shop'; $params = []; }
        elseif($intended=='book'){$route='browse.book';$params=['book'=>$bookId];}
        else{$route = 'browse.index'; $params = [];}

        // data update
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->phone = $data['phone'];
        $user->age = $data['age'];
        $user->gender = $data['gender'];
        $user->address = $data['address'];
        $user->region_id = $data['region'];
        $user->banned = false;

        $user->save();
        event(new Registered($user));

        $credentials = ['email' => $user->email,'password'=> $data['password'] ];

        if(Auth::attempt($credentials, true)){

            return redirect()->route($route, $params)
                ->with('success', __('messages.success_account_created'));
        }else{

            return redirect()->route('auth.registerPage', ['intended' => $intended, 'bid' => $bookId])
                ->with('error' , __('messages.error_unexpected'));
        }
    }


    public function logout()
    {
        // logout
        auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('browse.index')
            ->with('success' ,__('messages.success_logged_out'));
    }

}
