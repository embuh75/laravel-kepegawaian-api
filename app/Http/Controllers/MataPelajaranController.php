<?php

namespace App\Http\Controllers;

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

        return mata_pelajaran::paginate($perPage ? $request->perPage : 10)->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin', User::class);

        $data = $request->validate([
            'nama' => ['required', 'string', 'min:5', 'max:100'],
            'kode' => ['required', 'string', 'min:5', 'max:10', Rule::unique('mata_pelajarans', 'kode')],
        ]);

        $result = mata_pelajaran::create($data);
        $success = mata_pelajaran::save();

        return ['success' => $success, 'created' => $result];
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

        $data = $request->validate([
            'nama' => ['string', 'min:5', 'max:100'],
            'kode' => ['string', 'min:5', 'max:10', Rule::unique('mata_pelajarans', 'kode')],
        ]);

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
