<?php

namespace Database\Seeders;

use App\Models\jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        jabatan::create(['nama' => 'Tenaga Kebersihan', 'kode' => 'TK']);
        jabatan::create(['nama' => 'Tenaga Kebersihan dan Jaga Malam', 'kode' => 'TKJM']);
        jabatan::create(['nama' => 'TBendahara', 'kode' => 'BHR']);
        jabatan::create(['nama' => 'Tim Multimedia', 'kode' => 'TMM']);
    }
}
