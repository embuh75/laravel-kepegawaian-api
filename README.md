# LARAVEL KEPEGAWAIAN REST API

Sebuah RESTful API yang dibangun menggunakan **Laravel 13** untuk menyediakan layanan [Sebutkan tujuan aplikasi, misal: manajemen absensi dan data pegawai].

## Teknologi yang Digunakan

- **Framework:** Laravel
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Lainnya:** Laravel Scout, Eloquent

---

## Prasyarat

Sebelum menginstal aplikasi ini, pastikan komputer Anda sudah memenuhi prasyarat berikut:

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- NodeJS (Opsional)

---

## Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan API ini di komputer lokal Anda:

1. **Clone repository ini**

    ```bash
    git clone https://github.com/embuh75/laravel-kepegawaian-api
    cd laravel-kepegawaian-api
    ```

2. **Install dependency PHP**

    ```bash
    composer install
    ```

3. **Salin file environment**

    ```bash
    cp .env.example .env
    ```

4. **Konfigurasi Database**
   Buka file `.env` dan sesuaikan kredensial database Anda:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_kamu
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

6. **Migrasi Database & Seeding (Opsional)**

    ```bash
    php artisan migrate --seed
    ```

7. **Jalankan Server Lokal**
    ```bash
    php artisan serve
    ```
    API sekarang dapat diakses di: `http://localhost:8000`

---

## Autentikasi

API ini menggunakan metode autentikasi **Bearer Token**.
Untuk mengakses endpoint yang diproteksi, sertakan token pada HTTP Header saat melakukan request:

```http
Authorization: Bearer <token_anda_di_sini>
Accept: application/json
```

---

## Daftar Endpoint API

Berikut adalah daftar endpoint utama yang tersedia di API ini:

### Root (cek status)

```http
  GET /api/v1/
```

### Authentication

#### Login

```http
  POST /api/v1/auth/login
```

| Parameter  | Type     | Description            |
| :--------- | :------- | :--------------------- |
| `email`    | `string` | **Required**. email    |
| `password` | `string` | **Required**. password |

#### Check User (Auth Reequired)

```http
  GET /api/v1/auth/me
```

#### Logout (Auth Reequired)

```http
  POST /api/v1/auth/logout
```

### Users Management (Admin)

#### Register User (Auth Reequired)

```http
  POST /api/v1/user
```

| Body       | Type                  | Description                                                       |
| :--------- | :-------------------- | :---------------------------------------------------------------- |
| `name`     | `string`              | **Required**. nama user                                           |
| `role`     | `enum:'admin','user'` | **Required**. role/otorisasi, isi dengan admin/user               |
| `email`    | `string, email`       | **Required**. email harus unique                                  |
| `password` | `string`              | **Required**. password min 8 karakter ada angka dan huruf kapital |

#### Ambil semua data user (Auth Reequired)

perlu autentikasi dan hanya admin yang bisa akses.

```http
  GET /api/v1/user
```

| Parameter | Type      | Description                              |
| :-------- | :-------- | :--------------------------------------- |
| `name`    | `string`  | cari user dengan nama                    |
| `perPage` | `number`  | jumlah data yang ditampilkan per halaman |
| `page`    | `snumber` | navigasi halaman                         |

#### Ambil data user berdasarkan id (Auth Reequired)

```http
  GET /api/v1/user/:id
```

| Parameter | Type     | Description         |
| :-------- | :------- | :------------------ |
| `:id`     | `number` | cari user dengan id |

#### Update data user berdasarkan id (Auth Reequired)

```http
  PUT /api/v1/user/:id
```

| Parameter | Type     | Description         |
| :-------- | :------- | :------------------ |
| `:id`     | `number` | cari user dengan id |

| Body       | Type                  | Description                                         |
| :--------- | :-------------------- | :-------------------------------------------------- |
| `name`     | `string`              | nama user                                           |
| `role`     | `enum:'admin','user'` | role/otorisasi, isi dengan admin/user               |
| `email`    | `string, email`       | email harus unique                                  |
| `password` | `string`              | password min 8 karakter ada angka dan huruf kapital |

#### Hapus user berdasarkan id (Auth Reequired)

```http
  DELETE /api/v1/user/:id
```

| Parameter | Type     | Description         |
| :-------- | :------- | :------------------ |
| `:id`     | `number` | cari user dengan id |

### Mapel Management

perlu autentikasi dan hanya admin yang bisa CREATE, UPDATE, DELETE

#### Create Mapel (Auth Reequired)

```http
  POST /api/v1/worker/mapel
```

| Body   | Type     | Description                                       |
| :----- | :------- | :------------------------------------------------ |
| `nama` | `string` | nama mata pelajaran                               |
| `kode` | `string` | kode mata pelajaran min 1 karakter max 5 karakter |

#### Get Mapels (Auth Reequired)

```http
  GET /api/v1/worker/mapel
```

| Parameter | Type      | Description                              |
| :-------- | :-------- | :--------------------------------------- |
| `search`  | `string`  | cari mapel dengan nama/kode              |
| `perPage` | `number`  | jumlah data yang ditampilkan per halaman |
| `page`    | `snumber` | navigasi halaman                         |

#### Get Mapel by Id (Auth Reequired)

```http
  GET /api/v1/worker/mapel/:id
```

| Parameter | Type     | Description          |
| :-------- | :------- | :------------------- |
| `:id`     | `number` | cari mapel dengan id |

#### Update Mapel by Id (Auth Reequired)

```http
  PUT /api/v1/worker/mapel/:id
```

| Parameter | Type     | Description                 |
| :-------- | :------- | :-------------------------- |
| `:id`     | `number` | update mapel berdasarkan id |

| Body   | Type     | Description                                       |
| :----- | :------- | :------------------------------------------------ |
| `nama` | `string` | nama mata pelajaran                               |
| `kode` | `string` | kode mata pelajaran min 1 karakter max 5 karakter |

#### Delete Mapel by Id (Auth Reequired)

```http
  DELETE /api/v1/worker/mapel/:id
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `:id`     | `number` | hapus mapel berdasarkan id |

### Jabatan Management

perlu autentikasi dan hanya admin yang bisa CREATE, UPDATE, DELETE

#### Create Jabatan (Auth Reequired)

```http
  POST /api/v1/worker/jabatan
```

| Body   | Type     | Description                                |
| :----- | :------- | :----------------------------------------- |
| `nama` | `string` | nama jabatan                               |
| `kode` | `string` | kode jabatan min 1 karakter max 5 karakter |

#### Get Jabatans (Auth Reequired)

```http
  GET /api/v1/worker/jabatan
```

| Parameter | Type      | Description                              |
| :-------- | :-------- | :--------------------------------------- |
| `search`  | `string`  | cari jabatan dengan nama/kode            |
| `perPage` | `number`  | jumlah data yang ditampilkan per halaman |
| `page`    | `snumber` | navigasi halaman                         |

#### Get Jabatan by Id (Auth Reequired)

```http
  GET /api/v1/worker/jabatan/:id
```

| Parameter | Type     | Description            |
| :-------- | :------- | :--------------------- |
| `:id`     | `number` | cari jabatan dengan id |

#### Update Jabatan by Id (Auth Reequired)

```http
  PUT /api/v1/worker/jabatan/:id
```

| Parameter | Type     | Description                   |
| :-------- | :------- | :---------------------------- |
| `:id`     | `number` | update jabatan berdasarkan id |

| Body   | Type     | Description                                |
| :----- | :------- | :----------------------------------------- |
| `nama` | `string` | nama jabatan                               |
| `kode` | `string` | kode jabatan min 1 karakter max 5 karakter |

#### Delete Jabatan by Id (Auth Reequired)

```http
  DELETE /api/v1/worker/jabatan/:id
```

| Parameter | Type     | Description                  |
| :-------- | :------- | :--------------------------- |
| `:id`     | `number` | hapus jabatan berdasarkan id |

### Pegawai Management (Auth Required)

perlu autentikasi dan hanya admin yang bisa CREATE, UPDATE, DELETE

#### Create Pegawai

```http
  POST /api/v1/worker/pegawai
```

| Body                  | Type                                    | Description                            |
| :-------------------- | :-------------------------------------- | :------------------------------------- |
| `nama`                | `string`                                | Nama                                   |
| `foto`                | `file:webp,png,jpg,jpeg`                | file foto, boleh kosong                |
| `nomor_ktp`           | `number`                                | Nomor KTP harus unique                 |
| `nomor_nbm`           | `number`                                | Nomor NBM harus unique, boleh kosong   |
| `tempat_lahir`        | `string`                                | tempat lahir                           |
| `tanggal_lahir`       | `date(y:m:d)`                           | tanggal lahir (ex:1995-06-07)          |
| `jenis_kelamin`       | `enum:'L','P'`                          | jenis kelamin: L/P                     |
| `status`              | `enum:'Belum_Menikah','Menikah','Duda'` | status: Belum_Menikah/Menikah/Duda     |
| `alamat_rumah`        | `text`                                  | alamat rumah                           |
| `nomor_telephone`     | `string:phoneNumber`                    | nomor hp                               |
| `alamat_email`        | `string:email`                          | alamat email harus unik, boleh kosong  |
| `pendidikan_terakhir` | `string`                                | pendidikan terakhir, boleh kosong      |
| `nama_kampus`         | `string`                                | nama kampus, boleh kosong              |
| `jurusan`             | `string`                                | jurusan, boleh kosong                  |
| `tahun_lulus`         | `date(Y)`                               | tahun lulus,boleh kosong               |
| `jabatan_id`          | `number`                                | id jabatan                             |
| `mapel_id`            | `number`                                | id mapel, boleh kosong                 |
| `nomor_bpjs`          | `number`                                | nomor bpjs, boleh kosong               |
| `kontak_darurat`      | `string:phoneNumber`                    | kontak darurat,boleh kosong            |
| `user_id`             | `number`                                | user id pegawai untuk login jika punya |

#### Get Pegawais

```http
  GET /api/v1/worker/pegawai
```

| Parameter | Type      | Description                                                      |
| :-------- | :-------- | :--------------------------------------------------------------- |
| `search`  | `string`  | cari berdasarkan : nama, tempat_lahir, alamat_rumah, nama_kampus |
| `filter`  | `string`  | filter berdasarkan : jenis_kelamin, status, jabatan_kode         |
| `perPage` | `number`  | jumlah data yang ditampilkan per halaman                         |
| `page`    | `snumber` | navigasi halaman                                                 |

#### Get Pegawai by Id (Auth Reequired)

```http
  GET /api/v1/worker/pegawai/:id
```

| Parameter | Type     | Description                 |
| :-------- | :------- | :-------------------------- |
| `:id`     | `number` | cari pegawai berdasarkan id |

#### Update pegawai by Id (Auth Reequired)

```http
  PUT /api/v1/worker/pegawai/:id
```

| Parameter | Type     | Description                   |
| :-------- | :------- | :---------------------------- |
| `:id`     | `number` | update pegawai berdasarkan id |

| Body                  | Type                                    | Description                            |
| :-------------------- | :-------------------------------------- | :------------------------------------- |
| `nama`                | `string`                                | Nama                                   |
| `foto`                | `file:webp,png,jpg,jpeg`                | file foto, boleh kosong                |
| `nomor_ktp`           | `number`                                | Nomor KTP harus unique                 |
| `nomor_nbm`           | `number`                                | Nomor NBM harus unique, boleh kosong   |
| `tempat_lahir`        | `string`                                | tempat lahir                           |
| `tanggal_lahir`       | `date(y:m:d)`                           | tanggal lahir (ex:1995-06-07)          |
| `jenis_kelamin`       | `enum:'L','P'`                          | jenis kelamin: L/P                     |
| `status`              | `enum:'Belum_Menikah','Menikah','Duda'` | status: Belum_Menikah/Menikah/Duda     |
| `alamat_rumah`        | `text`                                  | alamat rumah                           |
| `nomor_telephone`     | `string:phoneNumber`                    | nomor hp                               |
| `alamat_email`        | `string:email`                          | alamat email harus unik, boleh kosong  |
| `pendidikan_terakhir` | `string`                                | pendidikan terakhir, boleh kosong      |
| `nama_kampus`         | `string`                                | nama kampus, boleh kosong              |
| `jurusan`             | `string`                                | jurusan, boleh kosong                  |
| `tahun_lulus`         | `date(Y)`                               | tahun lulus,boleh kosong               |
| `jabatan_id`          | `number`                                | id jabatan                             |
| `mapel_id`            | `number`                                | id mapel, boleh kosong                 |
| `nomor_bpjs`          | `number`                                | nomor bpjs, boleh kosong               |
| `kontak_darurat`      | `string:phoneNumber`                    | kontak darurat,boleh kosong            |
| `user_id`             | `number`                                | user id pegawai untuk login jika punya |

#### Delete pegawai by Id (Auth Reequired)

```http
  DELETE /api/v1/worker/pegawai/:id
```

| Parameter | Type     | Description                  |
| :-------- | :------- | :--------------------------- |
| `:id`     | `number` | hapus pegawai berdasarkan id |

---

## Kontributor

- **embuh75** - _Backend Developer_
