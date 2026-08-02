<?php

namespace Database\Factories;

use App\Models\jabatan;
use App\Models\mata_pelajaran;
use App\Models\pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            // min:10 => Digabung nama depan & belakang biar panjangnya pasti >= 10 karakter
            'nama' => "{$faker->name()} {$faker->lastName()}",

            // nullable image => di-set null dulu untuk seeder
            'foto' => null,

            // min:20, max:20 => Wajib persis 20 digit angka
            'nomor_ktp' => $faker->unique()->numerify('####################'),

            // min:10, max:20 => 14 digit angka
            'nomor_nbm' => $faker->unique()->numerify('##############'),

            // min:10 => Diberi awalan 'Kabupaten ' biar panjangnya pasti > 10 karakter
            'tempat_lahir' => 'Kabupaten '.$faker->city(),

            // date_format:Y-m-d & before:today
            'tanggal_lahir' => $faker->date('Y-m-d', '-20 years'),

            // in:L,P
            'jenis_kelamin' => $faker->randomElement(['L', 'P']),

            // in:Belum_Menikah,Menikah,Duda
            'status' => $faker->randomElement(['Belum_Menikah', 'Menikah', 'Duda']),

            // min:10 => Alamat Indonesia bawaan faker pasti > 10 karakter
            'alamat_rumah' => $faker->address(),

            // min:12, max:14 & phone:ID => '08' + 10 digit = 12 digit (Format HP Indonesia Valid)
            'nomor_telephone' => '08'.$faker->numerify('##########'),

            // email & unique
            'alamat_email' => $faker->unique()->safeEmail(),

            // min:2, max:5
            'pendidikan_terakhir' => $faker->randomElement(['D3', 'S1', 'S2', 'SMA', 'SMK']),

            // min:10
            'nama_kampus' => 'Universitas '.$faker->company(),

            // min:10
            'jurusan' => 'S1 '.$faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Pendidikan Matematika']),

            // date_format:Y
            'tahun_lulus' => (string) $faker->year(),

            // foreign key => Otomatis bikin / ambil dari JabatanFactory
            'jabatan_id' => jabatan::inRandomOrder()->first()?->id,

            // foreign key => Kadang diisi, kadang null
            'mapel_id' => mata_pelajaran::inRandomOrder()->first()?->id,

            // min:10, max:30
            'nomor_bpjs' => $faker->unique()->numerify('000###########'),

            // min:12, max:14 & phone:ID
            'kontak_darurat' => '08'.$faker->numerify('##########'),

            // nullable foreign key
            'user_id' => null,
        ];
    }
}
