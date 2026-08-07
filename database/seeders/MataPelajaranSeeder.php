<?php

namespace Database\Seeders;

use App\Models\mata_pelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(mata_pelajaran $mapel): void
    {
        $data = [
            ['nama' => 'Bahasa Arab', 'kode' => 'BAB'],
            ['nama' => 'Bahasa Indonesia', 'kode' => 'BID'],
            ['nama' => 'Matematika', 'kode' => 'MTK'],
            ['nama' => 'Kimia', 'kode' => 'KIM'],
            ['nama' => 'Fisika', 'kode' => 'FIS'],
            ['nama' => 'Pendidikan Agama Islam', 'kode' => 'PAI'],
            ['nama' => 'Biologi', 'kode' => 'BIO'],
            ['nama' => 'Bimbingan Konseling', 'kode' => 'BK'],
            ['nama' => 'Sejarah dan Pancasila', 'kode' => 'SP'],
            ['nama' => 'Ekonomi', 'kode' => 'EKO'],
            ['nama' => 'Geografi', 'kode' => 'GEO'],
            ['nama' => 'Sosiologi', 'kode' => 'SO'],
        ];

        foreach ($data as $mp) {
            $mapel->create($mp);
        }
    }
}
