<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('foto', 255)->nullable();
            $table->string('nomor_ktp', 20)->unique();
            $table->string('nomor_nbm', 20)->nullable()->unique();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L','P']);
            $table->enum('status', ['Belum_Menikah','Menikah','Duda']);
            $table->text('alamat_rumah');
            $table->string('nomor_telephone', 20);
            $table->string('alamat_email', 100)->nullable()->unique();
            $table->string('pendidikan_terakhir', 150)->nullable();
            $table->string('nama_kampus', 150)->nullable();
            $table->string('jurusan', 150)->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->foreignId('jabatan_id')->constrained('jabatans')->onDelete('cascade');
            $table->foreignId('mapel_id')->nullable()->constrained('mata_pelajarans')->onDelete('cascade');
            $table->string('nomor_bpjs', 30)->nullable()->unique();
            $table->string('kontak_darurat', 20)->nullable();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->onDelete('cascade');
            $table->fullText(['nama']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
