## Cashier Final Project

### Deskripsi

Ini adalah proyek aplikasi kasir berbasis **Laravel 11** dengan database **MySQL**, yang berjalan di **Laragon** sebagai local development environment. Aplikasi ini dirancang untuk membantu operasional kasir dengan fitur seperti manajemen produk, transaksi, laporan, dan lain-lain.

---

## Instalasi & Persiapan

### Persyaratan Sistem

Pastikan perangkat memiliki spesifikasi minimal berikut:

-   **OS**: Windows / Linux / MacOS
-   **RAM**: Minimal 4GB (disarankan 8GB+)
-   **Penyimpanan**: Minimal 1GB untuk proyek dan database

### Software yang Dibutuhkan

Sebelum menjalankan proyek, pastikan menginstal software berikut:

| Software                                        | Versi yang Direkomendasikan | Download |
| ----------------------------------------------- | --------------------------- | -------- |
| [Laragon](https://laragon.org/)                 | Minimal 5.0                 | ✅       |
| [PHP](https://www.php.net/downloads.php)        | 8.2 atau lebih baru         | ✅       |
| [Composer](https://getcomposer.org/)            | 2.6 atau lebih baru         | ✅       |
| [Node.js](https://nodejs.org/en)                | 18+ dengan NPM              | ✅       |
| [MySQL](https://dev.mysql.com/downloads/mysql/) | 8+                          | ✅       |
| [Laravel](https://laravel.com/)                 | 11                          | ✅       |

---

## Konfigurasi & Instalasi

### Clone Repository

Jalankan perintah berikut untuk mengunduh source code:

```sh
git clone https://github.com/zeftoxox/kasir.git
cd kasir
```

### Instal Dependencies Laravel

Jalankan perintah berikut untuk menginstal semua package Laravel:

```sh
composer install
```

### Konfigurasi Environment

Buat file `.env` dari contoh yang ada:

```sh
cp .env.example .env
```

Kemudian edit `.env` sesuai konfigurasi MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

### Generate Application Key

Jalankan perintah:

```sh
php artisan key:generate
```

### Migrasi & Seeder Database

Jalankan perintah berikut untuk membuat tabel database:

```sh
php artisan migrate --seed
```

### Jalankan Server

Setelah semua konfigurasi selesai, jalankan server Laravel dengan perintah:

```sh
php artisan serve
```

Akses aplikasi di browser dengan membuka:

```
http://127.0.0.1:8000
```

---

## Dependencies & Ekstensi yang Dibutuhkan

### Ekstensi PHP yang Wajib Diaktifkan

Pastikan ekstensi berikut diaktifkan di file `php.ini`:

```ini
extension=fileinfo
extension=mbstring
extension=openssl
extension=pdo_mysql
extension=gd
extension=zip
extension=bcmath
```

### NPM Dependencies untuk Frontend

Jika proyek menggunakan frontend berbasis **Vue.js** atau **React**, jalankan:

```sh
npm install
npm run dev
```

---

## Fitur Utama

-   Manajemen Produk
-   Manajemen Transaksi
-   Laporan Penjualan
-   Multi User (Admin & Kasir)
-   API untuk Integrasi
-   UI Responsif

---

## Troubleshooting

### Composer Tidak Dapat Mengunduh Dependencies

Coba jalankan perintah berikut:

```sh
composer update --ignore-platform-reqs
```

### Error Saat Migrasi Database

Pastikan MySQL berjalan, lalu coba reset database:

```sh
php artisan migrate:fresh --seed
```

### Port 8000 Sudah Digunakan

Jalankan Laravel dengan port lain:

```sh
php artisan serve --port=8080
```

---

## Lisensi

Proyek ini menggunakan lisensi **MIT**. Anda bebas untuk menggunakan dan mengembangkan proyek ini.

Jika menyukai proyek ini, jangan lupa untuk memberi bintang di repository GitHub.
