<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AutfKontroler extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json('Greška!', $validator->errors());
        } else {

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'user'
            ]);

            $user->createToken($user->username . 'token')->plainTextToken;

            return response()->json(
                [
                    'Info' => 'User successfully registered!'
                ]
            );
        }
    }
}
