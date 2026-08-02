<?php

namespace App\Http\Controllers;

use App\Http\Resources\PegawaiResourceCollection;
use App\Models\pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->filled('search');
        $filter = $request->filled('filter');
        $perPage = $request->filled('perPage');

        if ($search) {
            return new PegawaiResourceCollection(pegawai::search($request->search)->query(function ($query) {
                $query->with(['jabatan', 'mata_pelajaran']);
            })->paginate($perPage ? $request->perPage : 10));
        }

        if ($filter) {
            return new PegawaiResourceCollection(pegawai::search($request->filter)->query(function ($query) use ($request) {
                $query->with(['jabatan', 'mata_pelajaran']);
                // Filter Status (filter === 'Menikah'|'Belum_Menikah'|'Duda')
                if ($request->filter === 'Menikah' || $request->filter === 'Belum_Menikah' || $request->filter === 'Duda') {
                    $query->when($request->filter, fn ($q, $status) => $q->where('status', '=', $status));
                }

                // Filter Jenis Kelamin (filter === 'L'|'P'|)
                if ($request->filter === 'L' || $request->filter === 'P') {
                    $query->when($request->filter, fn ($q, $gender) => $q->where('jenis_kelamin', '=', $gender));
                }

                // Filter Jabatan by jabatans.kode
                $query->when($request->filter, fn ($q, $jabatan) => $q->where('jabatans.kode', '=', $jabatan));
            })->paginate($perPage ? $request->perPage : 10));
        }

        return new PegawaiResourceCollection(pegawai::with(['jabatan', 'mata_pelajaran'])->paginate($perPage ? $request->perPage : 10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, pegawai $pegawai)
    {
        Gate::authorize('admin', User::class);

        $data = $request->validate([
            'nama' => ['required', 'string', 'min:10', 'max:150'],
            'foto' => ['nullable', 'image', 'mimes:webp,png,jpg,jpeg', 'max:1048'],
            'nomor_ktp' => ['required', 'string', 'min:16', 'max:16', Rule::unique('pegawais', 'nomor_ktp')],
            'nomor_nbm' => ['nullable', 'string', 'min:10', 'max:20', Rule::unique('pegawais', 'nomor_nbm')],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d', 'before:today'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'status' => ['required', 'in:Belum_Menikah,Menikah,Duda'],
            'alamat_rumah' => ['required', 'string', 'min:10'],
            'nomor_telephone' => ['required', 'string', 'min:12', 'max:14', 'phone:ID'],
            'alamat_email' => ['nullable', 'string', 'min:10', 'max:100', 'email', Rule::unique('pegawais', 'alamat_email')],
            'pendidikan_terakhir' => ['nullable', 'string', 'min:2', 'max:5'],
            'nama_kampus' => ['nullable', 'string', 'min:10', 'max:150'],
            'jurusan' => ['nullable', 'string', 'min:10', 'max:150'],
            'tahun_lulus' => ['nullable', 'date_format:Y'],
            'jabatan_id' => ['exists:jabatans,id'],
            'mapel_id' => ['nullable', 'exists:mata_pelajarans,id'],
            'nomor_bpjs' => ['nullable', 'string', 'min:10', 'max:30', Rule::unique('pegawais', 'nomor_bpjs')],
            'kontak_darurat' => ['nullable', 'string', 'min:12', 'max:14', 'phone:ID'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('foto')) {
            // format nama
            $timestamp = now()->getTimestampMs();
            $random = rand(10000000, 999999999);
            $fileExt = $request->file('foto')->getClientOriginalExtension();
            $fileName = "IMG_{$random}_{$timestamp}.{$fileExt}";

            // storage
            $request->file('foto')->storeAs('upload', $fileName, 'public');

            $data['foto'] = $fileName;
        }

        $result = $pegawai->create($data);

        return ['success' => true, 'created' => $result];
    }

    /**
     * Display the specified resource.
     */
    public function show(pegawai $pegawai)
    {
        $result = pegawai::with(['jabatan', 'mata_pelajaran'])->findOrFail($pegawai->id);

        return ['success' => true, 'result' => $result->toResource()];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pegawai $pegawai)
    {
        Gate::authorize('admin', User::class);

        $data = $request->validate([
            'nama' => ['required', 'string', 'min:10', 'max:150'],
            'foto' => ['nullable', 'image', 'mimes:webp,png,jpg,jpeg', 'max:1048'],
            'nomor_ktp' => ['required', 'string', 'min:20', 'max:20', Rule::unique('pegawais', 'nomor_ktp')->ignore($pegawai->id)],
            'nomor_nbm' => ['nullable', 'string', 'min:10', 'max:20', Rule::unique('pegawais', 'nomor_nbm')->ignore($pegawai->id)],
            'tempat_lahir' => ['required', 'string', 'min:10', 'max:100'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d', 'before:today'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'status' => ['required', 'in:Belum_Menikah,Menikah,Duda'],
            'alamat_rumah' => ['required', 'string', 'min:10'],
            'nomor_telephone' => ['required', 'string', 'min:12', 'max:14', 'phone:ID'],
            'alamat_email' => ['nullable', 'string', 'min:10', 'max:100', 'email', Rule::unique('pegawais', 'alamat_email')->ignore($pegawai->id)],
            'pendidikan_terakhir' => ['nullable', 'string', 'min:2', 'max:5'],
            'nama_kampus' => ['nullable', 'string', 'min:10', 'max:150'],
            'jurusan' => ['nullable', 'string', 'min:10', 'max:150'],
            'tahun_lulus' => ['nullable', 'date_format:Y'],
            'jabatan_id' => ['exists:jabatans,id'],
            'mapel_id' => ['nullable', 'exists:mata_pelajarans,id'],
            'nomor_bpjs' => ['nullable', 'string', 'min:10', 'max:30', Rule::unique('pegawais', 'nomor_bpjs')->ignore($pegawai->id)],
            'kontak_darurat' => ['nullable', 'string', 'min:12', 'max:14', 'phone:ID'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('foto')) {
            $oldFoto = $pegawai->foto;
            $fotoExt = $request->file('foto')->getClientOriginalExtension();
            $fotoName = explode('.', $oldFoto);

            if ($oldFoto && $fotoExt === $fotoName[1]) {
                $fileName = $oldFoto;
            } else {
                $oldFotoFile = Storage::disk('public')->exists("upload/{$oldFoto}");

                if ($oldFoto && $oldFotoFile) {
                    Storage::disk('public')->delete("upload/{$oldFoto}");
                }

                $fileName = "{$fotoName[0]}.{$fotoExt}";
            }

            $request->file('foto')->storeAs('upload', $fileName, 'public');

            $data['foto'] = $fileName;
        }

        $success = $pegawai->update($data);

        return ['success' => $success, 'updated' => $pegawai->getChanges()];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pegawai $pegawai)
    {
        Gate::authorize('admin', User::class);

        $deleted = $pegawai;
        $foto = $pegawai->foto;
        $fileFoto = Storage::disk('public')->exists("upload/{$foto}");

        if ($foto && $fileFoto) {
            Storage::disk('public')->delete("upload/{$foto}");
        }

        $success = $pegawai->delete($pegawai->id);

        return ['success' => $success, 'deleted' => $deleted];
    }
}
