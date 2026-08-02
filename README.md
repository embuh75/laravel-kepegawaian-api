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

### Authentication

| Method | Endpoint        | Deskripsi                          | Auth Required |
| :----- | :-------------- | :--------------------------------- | :-----------: |
| `POST` | `/api/v1/auth/login`    | Login user & mendapatkan token     |      ❌       |
| `POST` | `/api/logout`   | Logout user & hapus token saat ini |      ✅       |

### Users Management

| Method   | Endpoint          | Deskripsi                        | Auth Required | Role  |
| :------- | :---------------- | :------------------------------- | :-----------: | :---: |
| `GET`    | `/api/users`      | Mengambil semua data user        |      ✅       | Admin |
| `GET`    | `/api/users/{id}` | Mengambil detail 1 user spesifik |      ✅       |  All  |
| `POST`   | `/api/users`      | Membuat data user baru           |      ✅       | Admin |
| `PUT`    | `/api/users/{id}` | Mengupdate data user             |      ✅       | Admin |
| `DELETE` | `/api/users/{id}` | Menghapus data user              |      ✅       | Admin |

_(Tambahkan tabel endpoint lainnya di sini sesuai kebutuhan project kamu)_

---

## Kontributor

- **embuh75** - _Backend Developer_ 
