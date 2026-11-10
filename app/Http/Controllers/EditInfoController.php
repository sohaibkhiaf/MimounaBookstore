<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EditInfoController extends Controller
{
    public function update(Request $request, User $user)
    {
        $intended = $request->input('intended');

        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|max:100',
            'phone' => 'required|size:10',
            'age' => 'required|integer',
            'gender' => 'required|between:0,1',
            'region' => 'required|between:1,58',
            'address' => 'required|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
            'new_password_confirmation' => 'nullable|min:8|string',
        ]);

        if (isset($data['new_password'], $data['new_password_confirmation']) && ! isset($data['current_password'])) {
            return to_route('account.info', ['action' => 'edit', 'intended' => $intended])
                ->with('error', __('messages.error_password_mandatory'));
        }

        if (isset($data['current_password'], $data['new_password'])) {
            if (! Hash::check($data['current_password'], $request->user()->password)) {
                return to_route('account.info', ['action' => 'edit', 'intended' => $intended])
                    ->with('error', __('messages.error_current_password'));
            }
            $user->password = Hash::make($data['new_password']);
        }

        if (isset($data['email']) && $user->email !== $data['email'] && $user->email_verified_at === null) {
            $user->email = $data['email'];
        }

        $user->fill([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'region_id' => $data['region'],
        ])->save();

        [$route, $params] = $intended === 'cart'
            ? ['browse.cart', []]
            : ['account.info', ['action' => 'edit']];

        return to_route($route, $params)
            ->with('success', __('messages.success_account_info'));
    }
}
