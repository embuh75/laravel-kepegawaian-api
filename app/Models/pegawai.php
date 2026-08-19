<?php

namespace App\Models;

use Database\Factories\PegawaiFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class pegawai extends Model
{
    /** @use HasFactory<PegawaiFactory> */
    use HasFactory;

    use Searchable;

    protected $fillable = [
        'nama',
        'foto',
        'nomor_ktp',
        'nomor_nbm',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'status',
        'alamat_rumah',
        'nomor_telephone',
        'alamat_email',
        'pendidikan_terakhir',
        'nama_kampus',
        'jurusan',
        'tahun_lulus',
        'jabatan_id',
        'mapel_id',
        'nomor_bpjs',
        'kontak_darurat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tahun_lulus' => 'integer',
            'jabatan_id' => 'integer',
            'mapel_id' => 'integer',
        ];
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(jabatan::class, 'jabatan_id');
    }

    public function mata_pelajaran(): BelongsTo
    {
        return $this->belongsTo(mata_pelajaran::class, 'mapel_id');
    }

    // ini yang gantiin peran eager-load — nge-JOIN tabel jabatan
    public function newScoutQuery(): Builder
    {
        return $this->newQuery()
            ->select('pegawais.*') // wajib, biar kolom 'nama' pegawai nggak ketiban 'nama' jabatan
            ->join('jabatans', 'jabatans.id', '=', 'pegawais.jabatan_id');
    }

    public function toSearchableArray(): array
    {
        return [
            /* search */
            'nama' => $this->nama,
            'tempat_lahir' => $this->tempat_lahir,
            'alamat_rumah' => $this->alamat_rumah,
            'nama_kampus' => $this->nama_kampus,
            /* filter */
            'jenis_kelamin' => $this->jenis_kelamin,
            'status' => $this->status,
            'jabatans.kode' => '',
        ];
    }
}
