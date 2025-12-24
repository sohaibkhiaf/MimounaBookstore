<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class EditInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // get params
        $intended = request()->input('intended');

        // validate data
        $data = request()->validate([
            'name' => 'required|string|max:50',
            'email'=> 'nullable|email|max:100',
            'phone' => 'required|size:10',
            'age' => 'required|integer',
            'gender' => 'required|between:0,1',
            'region' => 'required|between:1,58',
            'address' => 'required|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
            'new_password_confirmation' => 'nullable|min:8|string',
        ]);

        // set intended view
        if($intended == 'cart'){$route = 'browse.cart';$params = [];}
        else{ $route = 'account.info';$params = ['action' => 'show']; }

        // check current password when user trying to set a new password
        if(isset($data['new_password']) && isset($data['new_password_confirmation']) && !isset($data['current_password'])){
            return redirect()->route('account.info', ['action' => 'edit', 'intended' => $intended])->with('error' , __('messages.error_password_mandatory'));
        }else{

            // edit information
            $user->name = $data['name'];
            if(isset($data['email']) && $user->email !== $data['email'] && $user->email_verified_at === null){
                $user->email = $data['email'];
            }
            if(isset($data['current_password']) && isset($data['new_password'])){
                if(Hash::check($data['current_password'], auth()->user()->password) ){
                    $user->password = Hash::make($data['new_password']);
                }else{
                    return redirect()->route('account.info', ['action' => 'edit', 'intended' => $intended])->with('error', __('messages.error_current_password'));
                }
            }
            $user->phone = $data['phone'];
            $user->age = $data['age'];
            $user->gender = $data['gender'];
            $user->address = $data['address'];
            $user->region_id = $data['region'];

            $user->save();

            // return to intended view
            return redirect()->route($route, $params)->with('success',  __('messages.success_account_info'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
