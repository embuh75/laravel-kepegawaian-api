<?php

namespace App\Http\Controllers;

use App\Http\Resources\Mata_PelajaranResourceCollection;
use App\Models\mata_pelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->filled('perPage');
        $search = $request->filled('search');

        if ($search) {
            return new Mata_PelajaranResourceCollection(mata_pelajaran::search($request->search)->paginate($perPage ? $request->perPage : 10));
        }

        return new Mata_PelajaranResourceCollection(mata_pelajaran::paginate($perPage ? $request->perPage : 10));
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
                'kode' => ['required', 'string', 'min:1', 'max:5', Rule::unique('mata_pelajarans', 'kode')],
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

        return ['success' => true, 'created' => mata_pelajaran::create($data)];
    }

    /**
     * Display the specified resource.
     */
    public function show(mata_pelajaran $mapel)
    {
        return ['success' => true, 'result' => $mapel->toResource()];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, mata_pelajaran $mapel)
    {
        Gate::authorize('admin', User::class);

        $data = $request->validate(
            [
                'nama' => ['string', 'min:5', 'max:50'],
                'kode' => ['string', 'min:1', 'max:5', Rule::unique('mata_pelajarans', 'kode')],
            ],
            [
                'nama.min' => 'nama minimal 5 karakter!.',
                'nama.max' => 'nama maksimal 50 karakter!.',
                'kode.min' => 'kode minimal 1 karakter!.',
                'kode.max' => 'kode maksimal 5 karakter!.',
                'kode.unique' => 'kode sudah digunakan, kode harus unik!.',
            ]
        );

        $success = $mapel->update($data);

        return ['success' => $success, 'updated' => $mapel->getChanges()];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(mata_pelajaran $mapel)
    {
        Gate::authorize('admin', User::class);

        $result = $mapel;
        $success = $mapel->delete($mapel->id);

        return ['success' => $success, 'deleted' => $result];
    }
}
