<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PegawaiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $photo = Storage::disk('public')->exists("upload/{$this->foto}");
        $url = null;

        if ($this->foto && $photo) {
            $url = url(Storage::temporaryUrl("upload/{$this->foto}", now()->plus(minutes: 5)));
        }

        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'foto' => $url,
            'nomor_ktp' => $this->nomor_ktp,
            'nomor_nbm' => $this->nomor_nbm,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status' => $this->status,
            'alamat_rumah' => $this->alamat_rumah,
            'nomor_telephone' => $this->nomor_telephone,
            'alamat_email' => $this->alamat_email,
            'pendidikan_terakhir' => $this->pendidikan_terakhir,
            'nama_kampus' => $this->nama_kampus,
            'jurusan' => $this->jurusan,
            'tahun_lulus' => $this->tahun_lulus,
            'jabatan' => new JabatanResource($this->whenLoaded('jabatan')),
            'mata_pelajaran' => new Mata_PelajaranResource($this->whenLoaded('mata_pelajaran')),
            'nomor_bpjs' => $this->nomor_bpjs,
            'kontak_darurat' => $this->kontak_darurat,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
