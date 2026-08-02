<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class mata_pelajaran extends Model
{
    /** @use HasFactory<\Database\Factories\MataPelajaranFactory> */
    use HasFactory, Searchable;

    public $timestamps = false;
    protected $fillable = ['nama', 'kode'];

    public function toSearchableArray(): array
    {
        return [
            'nama' => $this->nama,
            'kode' => $this->kode
        ];
    }
}
