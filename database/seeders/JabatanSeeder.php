<?php

namespace Database\Seeders;

use App\Models\jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(jabatan $jabatan): void
    {
        $data = [
            ['nama' => 'Wa Ka AIK', 'kode' => 'WKA'],
            ['nama' => 'Guru', 'kode' => 'GR'],
            ['nama' => 'Waka Sarana dan Prasarana', 'kode' => 'WSP'],
            ['nama' => 'Kepala Sekolah', 'kode' => 'KS'],
            ['nama' => 'Tenaga Kebersihan', 'kode' => 'TK'],
            ['nama' => 'Tenaga Kebersihan dan Penjaga Malam', 'kode' => 'TKPM'],
            ['nama' => 'Tim Multimedia', 'kode' => 'TMM'],
        ];

        foreach ($data as $jb) {
            $jabatan->create($jb);
        }
    }
}
