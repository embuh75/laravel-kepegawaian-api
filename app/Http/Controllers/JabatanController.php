<?php

namespace App\Http\Controllers;

use App\Http\Resources\JabatanResourceCollection;
use App\Models\jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->filled('perPage');
        $search = $request->filled('search');

        if ($search) {
            return new JabatanResourceCollection(jabatan::search($request->search)->paginate($perPage ? $request->perPage : 10));
        }

        return new JabatanResourceCollection(jabatan::paginate($perPage ? $request->perPage : 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin', User::class);

        $data = $request->validate(
            [
                'nama' => ['required', 'string', 'min:5', 'max:50'],
                'kode' => ['required', 'string', 'min:1', 'max:5', Rule::unique('jabatans', 'kode')],
            ],
            [
                'nama.required' => 'nama tidak boleh kosong!.',
                'nama.min' => 'nama minimal 5 karakter!.',
                'nama.max' => 'nama maksimal 50 karakter!.',
                'kode.required' => 'kode tidak boleh kosong!.',
                'kode.min' => 'kode minimal 1 karakter!.',
                'kode.max' => 'kode maksimal 5 karakter!.',
                'kode.unique' => 'kode sudah digunakan, kode harus unik!.',
            ]
        );

        return ['success' => true, 'created' => jabatan::create($data)];
    }

    /**
     * Display the specified resource.
     */
    public function show(jabatan $jabatan)
    {
        return ['success' => true, 'result' => $jabatan->toResource()];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, jabatan $jabatan)
    {
        Gate::authorize('admin', User::class);

        $data = $request->validate(
            [
                'nama' => ['string', 'min:5', 'max:50'],
                'kode' => ['string', 'min:1', 'max:5', Rule::unique('jabatans', 'kode')],
            ],
            [
                'nama.min' => 'nama minimal 5 karakter!.',
                'nama.max' => 'nama maksimal 50 karakter!.',
                'kode.min' => 'kode minimal 1 karakter!.',
                'kode.max' => 'kode maksimal 5 karakter!.',
                'kode.unique' => 'kode sudah digunakan, kode harus unik!.',
            ]);

        return ['success' => $jabatan->update($data), 'updated' => $jabatan->getChanges()];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jabatan $jabatan)
    {
        Gate::authorize('admin', User::class);

        return ['success' => $jabatan->delete($jabatan->id), 'deleted' => $jabatan];
    }
}
