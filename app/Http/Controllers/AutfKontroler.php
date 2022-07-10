<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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

            return response()->json([
                'Info' => 'User successfully registered!'
            ]);
        }
    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['Info' => 'Unesite username i password!']);
        }

        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json(['Info' => 'Pokušajte ponovo!']);
        }

        $user = User::where('username', $request['username'])->firstOrFail();

        $token = $user->createToken($user->username . 'login_token')->plainTextToken;

        return response()->json([
            'Info' => 'User successfully logged in!',
            'User' => $user,
            'Token' => $token
        ]);
    }
}
