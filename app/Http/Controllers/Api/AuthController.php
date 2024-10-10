<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function register() {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
 
        $user = User::create($data);
        $token = $user->createToken('main')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login() {
        $data = request()->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::query()->firstWhere('email', $data['email']);
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Khong ton tai tai khoan'
            ],401);
        }

        $token = $user->createToken('main')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function logout(Request $request) {
    
        if($request -> type == 'all'){

            $request->user()->tokens()->delete();
        }else{

            $request->user()->currentAccessToken()->delete();
        }
        return response()->noContent();
    }
}
