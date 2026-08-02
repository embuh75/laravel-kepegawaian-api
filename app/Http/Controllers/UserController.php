<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        Gate::authorize('admin', $user);

        $perPage = $request->filled('perPage');
        $name = $request->filled('name');

        if ($name) {
            return new UserResourceCollection($user->search($request->name)->paginate($perPage ? $request->perPage : 10));
        }

        return new UserResourceCollection($user->paginate($perPage ? $request->perPage : 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        Gate::authorize('admin', $user);

        $data = $request->validate(
            [
                'name' => ['required', 'string', 'min:5', 'max:50'],
                'role' => ['required', 'in:admin,user'],
                'email' => ['required', 'string', 'min:10', 'max:50', 'email', Rule::unique('users', 'email')],
                'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            ],
            [
                'nama.required' => 'nama tidak boleh kosong!.',
                'nama.min' => 'nama minimal 5 karakter!.',
                'nama.max' => 'nama maksimal 50 karakter!.',
                'role.required' => 'role tidak boleh kosong!.',
                'role.in' => 'role input salah!, isi dengan admin/user.',
                'email.required' => 'email tidak boleh kosong!',
                'email.email' => 'format email yang anda masukan salah!',
                'email.min' => 'email minimal 10 karakter!',
                'email.max' => 'email maksimal 50 karakter!',
                'email.unique' => 'email sudah pernah dipakai!.',
                'password.required' => 'password tidak boleh kosong',
            ]
        );

        return ['success' => true, 'created' => $user->create($data)];
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('admin', $user);

        $result = $user->findOrFail($user->id);

        return ['succsess' => true, 'user' => $result->toResource()];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('admin', $user);

        $data = $request->validate(
            [
                'name' => ['required', 'string', 'min:5', 'max:50'],
                'role' => ['required', 'in:admin,user'],
                'email' => ['required', 'string', 'min:10', 'max:50', 'email', Rule::unique('users', 'email')->ignore($user->id)],
                'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            ],
            [
                'nama.required' => 'nama tidak boleh kosong!.',
                'nama.min' => 'nama minimal 5 karakter!.',
                'nama.max' => 'nama maksimal 50 karakter!.',
                'role.required' => 'role tidak boleh kosong!.',
                'role.in' => 'role input salah!, isi dengan admin/user.',
                'email.required' => 'email tidak boleh kosong!',
                'email.email' => 'format email yang anda masukan salah!',
                'email.min' => 'email minimal 10 karakter!',
                'email.max' => 'email maksimal 50 karakter!',
                'email.unique' => 'email sudah pernah dipakai!.',
                'password.required' => 'password tidak boleh kosong',
            ]
        );

        $success = $user->update($data);

        return ['success' => $success, 'message' => 'Data user berhasil diperbarui!'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('admin', $user);

        $success = $user->delete($user->id);

        return ['success' => $success, 'deleted' => $user];
    }
}
