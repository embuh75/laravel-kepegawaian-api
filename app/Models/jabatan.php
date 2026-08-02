<?php

namespace App\Models;

use Database\Factories\JabatanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class jabatan extends Model
{
    /** @use HasFactory<JabatanFactory> */
    use HasFactory, Searchable;

    public $timestamps = false;

    protected $fillable = ['nama', 'kode'];

    public function toSearchableArray(): array
    {
        return [
            'nama' => $this->nama,
            'kode' => $this->kode,
        ];
    }
}
