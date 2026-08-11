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

        $request->validate(
            [
                'nama' => ['string', 'min:5', 'max:50'],
                'kode' => ['string', 'min:1', 'max:5', Rule::unique('mata_pelajarans', 'kode')],
            ],
        );

        $mapel->update($request);
        $updated = $mapel->getChanges();

        if ($updated == null) {
            return ['success' => false, 'message' => 'isi dulu kolom yang ingin diupdate'];
        }

        return ['success' => true, 'updated' => $updated];
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
