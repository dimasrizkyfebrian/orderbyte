# Sistem Informasi Manajemen Kafe

Sebuah aplikasi web yang dibangun dengan Laravel untuk mengelola alur pemesanan di sebuah kafe, mulai dari pemesanan oleh pelanggan, konfirmasi kasir, proses di dapur, hingga pelaporan di panel admin.

## Fitur Utama

- **Sistem Multi-Role:** Akses terpisah untuk Pelanggan, Kasir, Dapur, dan Admin.
- **Pemesanan Mandiri:** Pelanggan dapat melihat menu, memesan, dan melihat riwayat pesanannya.
- **Dasbor Kasir:** Manajemen pembayaran, penyelesaian order, dan fitur cetak struk.
- **Tampilan Dapur (KDS):** Menerima pesanan secara real-time (dengan polling) dan mengurangi stok otomatis.
- **Panel Admin (Filament):**
    - Laporan penjualan dengan filter tanggal dan status.
    - Grafik tren penjualan dan menu terlaris.
    - Manajemen ulasan dari pelanggan.
- **Sistem Review & Rating:** Pelanggan dapat memberikan rating dan ulasan untuk menu yang telah dipesan.
- **Branding & Personalisasi:** Logo, warna, dan favicon yang bisa disesuaikan.

## Teknologi yang Digunakan

- **Framework:** Laravel 11
- **UI/Interactivity:** Livewire 3
- **Panel Admin:** Filament 3
- **Styling:** Tailwind CSS
- **Database:** MySQL

## Cara Instalasi & Setup

1.  Clone repositori ini: `git clone [URL_REPOSITORY_ANDA]`
2.  Masuk ke direktori proyek: `cd [NAMA_FOLDER_PROYEK]`
3.  Salin file `.env.example` menjadi `.env`: `cp .env.example .env`
4.  Install dependensi PHP: `composer install`
5.  Generate application key: `php artisan key:generate`
6.  Konfigurasi koneksi database di dalam file `.env`.
7.  Jalankan migrasi untuk membuat tabel-tabel di database: `php artisan migrate`
8.  Buat symbolic link untuk storage: `php artisan storage:link`
9.  Install dependensi JavaScript: `npm install`
10. Jalankan server development:
    - Di terminal pertama: `npm run dev`
    - Di terminal kedua: `php artisan serve`
11. Buka aplikasi di `http://127.0.0.1:8000`.