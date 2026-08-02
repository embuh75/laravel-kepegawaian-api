<?php

namespace App\Models;

use Database\Factories\JabatanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    /** @use HasFactory<JabatanFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['nama', 'kode'];
}
