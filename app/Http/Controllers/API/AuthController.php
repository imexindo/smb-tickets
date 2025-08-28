<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid email!',
                ]);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid email or password!'
                ]);
            }

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Login successful!',
                'data' => [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                    'token' => $token,
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error: ' . $th->getMessage()
            ]);
        }
    }

    public function profile()
    {

        try {
            $user = Auth::user();
            $roles = $user->getRoleNames();

            return response()->json([
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $roles 
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error: ' . $th->getMessage()
            ]);
        }
    }
}
