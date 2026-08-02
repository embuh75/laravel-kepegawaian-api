<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'min:10', 'max:50', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();
        $password = Hash::check($request->password, $user->password);

        if (! $user || ! $password) {
            return ['success' => false, 'message' => 'Kredensial yang anda masukan salah!'];
        }

        return [
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'email' => $user->email,
            ],
            'accessToken' => $user->createToken('login')->plainTextToken,
        ];
    }

    public function check(Request $request)
    {
        $user = $request->user();

        return [
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'email' => $user->email,
            ],
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ['success' => true, 'message' => 'User berhasil logout!'];
    }
}
