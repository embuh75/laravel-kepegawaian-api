<?php

namespace Database\Seeders;

use App\Models\mata_pelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        mata_pelajaran::create([
            'nama' => 'Bimbingan Konseling',
            'kode' => 'BK',
        ]);

        mata_pelajaran::create([
            'nama' => 'Sejarah dan Pancasila',
            'kode' => 'SP',
        ]);

        mata_pelajaran::create([
            'nama' => 'Ekonomi',
            'kode' => 'EKO',
        ]);

        mata_pelajaran::create([
            'nama' => 'Geografi',
            'kode' => 'GEO',
        ]);

        mata_pelajaran::create([
            'nama' => 'Sosiologi',
            'kode' => 'SOS',
        ]);
    }
}
