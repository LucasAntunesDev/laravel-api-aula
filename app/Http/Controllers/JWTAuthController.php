<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthController extends Controller {
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        try {
            if (!JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $user = JWTAuth::user();

            # No caso de atribuir um papel
            #$token = JWTAuth::claims(['role' => $user->role])->fromUser($user);
            $token = JWTAuth::fromUser($user);

            return response()->json(compact('token'));
        } catch (JWTException $exception) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public function logout() {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Logout succesfully'], 200);
    }
}
