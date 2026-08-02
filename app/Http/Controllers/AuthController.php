<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'string', 'min:10', 'max:50', 'email'],
                'password' => ['required', 'string'],
            ], 
            [
                'email.required' => 'email tidak boleh kosong!',
                'email.email' => 'format email yang anda masukan salah!',
                'email.min' => 'email minimal 10 karakter!',
                'email.max' => 'email maksimal 50 karakter!',
                'password.required' => 'password tidak boleh kosong'
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
