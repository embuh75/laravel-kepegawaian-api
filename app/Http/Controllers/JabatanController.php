<?php

namespace App\Http\Controllers;

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

        return jabatan::paginate($perPage ? $request->perPage : 10)->toResourceCollection();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin', User::class);

        $data = $request->validate([
            'nama' => ['required', 'string', 'min:5', 'max:50'],
            'kode' => ['required', 'string', 'min:1', 'max:5', Rule::unique('jabatan', 'kode')],
        ]);

        return ['success' => jabatan::save(), 'created' => jabatan::create($data)];
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

        $data = $request->validate([
            'nama' => ['string', 'min:5', 'max:50'],
            'kode' => ['string', 'min:1', 'max:5', Rule::unique('jabatan', 'kode')],
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
