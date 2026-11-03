# Sistem Pendaftaran Beasiswa Kampus Online — Portal Akademik
**Uji Kompetensi BNSP — Skema Sertifikasi: Junior Web Developer (FR.SKEMA-02-07)**
**Author: Sena**

Aplikasi web berbasis **PHP 8.3 / Laravel Framework** yang dirancang untuk memenuhi seluruh standar unit kompetensi BNSP pada studi kasus pendaftaran beasiswa mahasiswa berdasarkan Indeks Prestasi Kumulatif (IPK) terakhir secara otomatis dan terstruktur. Mengusung antarmuka **Portal Akademik Kampus** bernuansa *Royal Blue, Slate, Amber & Emerald*.

---

## 📋 Pemenuhan Unit Kompetensi BNSP

| Kode Unit | Judul Unit Kompetensi | Implementasi pada Sistem |
| :--- | :--- | :--- |
| **J.620100.005.02** | Mengimplementasikan User Interface | Antarmuka responsif, modern, navbar tab menu interaktif (Menu 1, 2, 3), kartu beasiswa, dan tabel hasil rapi. |
| **J.620100.010.01** | Menerapkan Perintah Eksekusi Pemrograman Berbasis Teks, Grafik, dan Multimedia | Upload & preview/download berkas (PDF/Gambar/ZIP), serta visualisasi grafik interaktif Chart.js pada halaman hasil. |
| **J.620100.015.01** | Menyusun Fungsi, File atau Sumber Daya Pemrograman dalam Organisasi yang Rapi | Struktur MVC Laravel, pemisahan Form Request, aset tersusun, dan DocBlock komentar standar BNSP lengkap di setiap modul. |
| **J.620100.016.01** | Menulis Kode dengan Prinsip Guidelines & Best Practices | Validasi ketat, `@error` handling, blok `try-catch`, pencegahan SQL injection & XSS, penamaan konsisten, lolos linting Laravel Pint. |
| **J.620100.017.02** | Mengimplementasikan Pemrograman Terstruktur | Logika otomasi IPK (< 3.0 vs >= 3.0), sanitasi input nomor HP numerik, perulangan data, dan fungsi modular. |
| **J.620100.019.02** | Menggunakan Library atau Komponen Pre-Existing | Laravel Framework, Blade templating, Chart.js (grafik multimedia), Tailwind CSS, Lucide SVG Icons. |

---

## 🚀 Panduan Cara Menjalankan Aplikasi (Langkah Cepat)

Aplikasi saat ini **sudah terkonfigurasi dan berjalan**. Jika Anda membuka terminal baru di folder proyek (`BNSP`), ikuti langkah berikut:

### 1. Prasyarat Sistem
- **PHP** >= 8.2 (Direkomendasikan PHP 8.3 via Laragon / XAMPP)
- **Composer** (Dependency Manager PHP)
- **Node.js** >= 18 & **NPM**

### 2. Jalankan Server Lokal (Laravel)
Buka terminal (PowerShell / Command Prompt) di folder proyek:
```bash
php artisan serve
```
> Server akan berjalan di: **[http://127.0.0.1:8000](http://127.0.0.1:8000)** atau **[http://localhost:8000](http://localhost:8000)**.

### 3. Kompilasi Aset Frontend (Jika Ingin Mengubah Tampilan)
Jika Anda mengubah file Blade atau CSS, jalankan Vite:
```bash
# Untuk mode pengembangan aktif (Hot Module Reload):
npm run dev

# ATAU kompilasi file produksi langsung:
npm run build
```

---

## 🛠️ Langkah Instalasi Awal Dari Nol (Fresh Setup)

Jika memindahkan folder ini ke laptop lain atau saat demonstrasi di depan Asesor:

```bash
# 1. Install dependensi PHP
composer install

# 2. Salin file environment
copy .env.example .env

# 3. Generate Application Key
php artisan key:generate

# 4. Hubungkan Storage Public (Agar berkas upload bisa diakses/didownload)
php artisan storage:link

# 5. Jalankan Migrasi & Data Seeder Awal
php artisan migrate --seed

# 6. Install dependensi frontend & build aset
npm install
npm run build

# 7. Jalankan server Laravel
php artisan serve
```

---

## 🗄️ Konfigurasi Database (MySQL / SQLite)

Secara bawaan (*out-of-the-box*), proyek ini telah disiapkan dan dimigrasikan menggunakan **SQLite** (`database/database.sqlite`) agar dapat langsung diuji tanpa perlu menyalakan service eksternal.

Jika Asesor meminta koneksi ke **MySQL (Laragon / XAMPP)**:
1. Pastikan MySQL di Laragon / XAMPP sudah dinyalakan (*Start*).
2. Buat database baru di phpMyAdmin / HeidiSQL dengan nama: `beasiswa_kampus`.
3. Buka file `.env`, ubah baris database menjadi:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=beasiswa_kampus
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Jalankan perintah migrasi dan seeder:
   ```bash
   php artisan migrate:fresh --seed
   ```

---

## 🎯 Panduan Demonstrasi Pengujian Asesor (Alur Sistem)

### A. Menu 1: Pilihan Beasiswa (`/` atau `/beasiswa`)
1. Buka browser pada tab menu **1. Pilihan Beasiswa**.
2. Terdapat minimal 2 pilihan beasiswa lengkap dengan kriteria IPK minimal &ge; 3.00, alokasi kuota, fasilitas cakupan beasiswa, dan syarat berkas.
3. Klik tombol **"Daftar Beasiswa Ini"** untuk langsung menuju form pendaftaran dengan pre-select jenis beasiswa.

### B. Menu 2: Daftar Beasiswa (`/daftar`)
Halaman ini memiliki **Panel Simulator IPK Khusus Asesor**:
1. **Uji Skenario IPK Tidak Lolos (< 3.00)**:
   - Klik tombol **"IPK 2.90 (Tidak Lolos)"** pada simulator.
   - **Respon Sistem**:
     - Muncul *Alert Warning Box* kuning: *"Maaf, IPK Anda di bawah 3.00, Anda tidak memenuhi syarat untuk mendaftar beasiswa."*
     - Dropdown **Pilihan Beasiswa** berubah menjadi **NON-AKTIF (Disabled)**.
     - Input **Upload Berkas** berubah menjadi **NON-AKTIF (Disabled)**.
     - Tombol **Daftar Beasiswa** berubah menjadi **NON-AKTIF (Disabled)**.
2. **Uji Skenario IPK Lolos (&ge; 3.00)**:
   - Klik tombol **"IPK 3.40 (Lolos Syarat)"** atau **"Acak IPK"**.
   - **Respon Sistem**:
     - Kotak peringatan otomatis **HILANG**.
     - Dropdown Pilihan Beasiswa, Upload Berkas, dan Tombol Daftar menjadi **AKTIF (Enabled)**.
     - **Auto-Focus**: Kursor secara otomatis langsung fokus ke dropdown **Pilihan Beasiswa**.
3. **Uji Validasi Form**:
   - Coba masukkan nomor HP dengan huruf (otomatis difilter hanya numerik).
   - Masukkan nomor HP kurang dari 10 digit, form akan menampilkan error `@error('nomor_hp')`.
   - Unggah file selain format PDF/JPG/PNG/ZIP atau di atas 2MB untuk memicu validasi format.
4. **Uji Submit Sukses**:
   - Isi: Nama Lengkap, Email valid, No. HP (10-13 digit), Pilih Semester (1-8), Pilih Beasiswa, dan unggah berkas (contoh file PDF).
   - Klik **"Daftar Beasiswa"**.
   - Sistem akan menyimpan berkas ke `storage/app/public/berkas_beasiswa` dan data ke tabel database `beasiswa_registrations`, kemudian me-redirect ke halaman hasil dengan notifikasi sukses.

### C. Menu 3: Hasil / Rekapitulasi (`/hasil`)
1. Menampilkan ringkasan metrik statistik (Total Pendaftar, Belum Diverifikasi, Terverifikasi, Ditolak).
2. **Grafik Interaktif (Chart.js)**:
   - Grafik 1: Distribusi peminat Pilihan Beasiswa (Doughnut Chart).
   - Grafik 2: Rekapitulasi status verifikasi ajuan (Bar Chart).
3. **Tabel Data Pendaftar**:
   - Kolom lengkap: No, Nama, Email & No HP, Semester, IPK, Pilihan Beasiswa, Berkas, Status Ajuan (Default: **Belum diverifikasi**), dan Aksi Verifikasi.
   - **Tombol Download & Preview Berkas**: Klik icon unduh untuk mendownload file, atau icon mata untuk melihat preview berkas di browser.
   - **Ubah Status Verifikasi**: Dropdown pada kolom paling kanan memungkinkan Asesor menguji pengubahan status menjadi **"Terverifikasi"** atau **"Ditolak"**.

---

## 🧪 Menjalankan Pengujian Otomatis (Automated Tests)

Pengujian fitur telah dibuat sesuai standar PHPUnit:
```bash
php artisan test --compact tests/Feature/BeasiswaRegistrationTest.php
```
Hasil:
- `6 passed, 21 assertions` mencakup pengujian routing, validasi IPK < 3.0, validasi nomor HP, pengunggahan berkas, dan penyimpanan database.

---

## 📁 Struktur Berkas Penting

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── BeasiswaController.php       # Controller utama (DocBlock BNSP)
│   │   └── Requests/
│   │       └── StoreBeasiswaRequest.php     # Validasi ketat & pesan ramah
│   └── Models/
│       └── BeasiswaRegistration.php         # Model & accessors berkas/badge
├── database/
│   ├── migrations/
│   │   └── 2026_09_07_000001_create_beasiswa_registrations_table.php
│   └── seeders/
│       └── BeasiswaRegistrationSeeder.php   # Sample data pengujian asesor
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php                    # Layout master & Tab Menu
│   └── beasiswa/
│       ├── index.blade.php                  # Menu 1: Pilihan Beasiswa
│       ├── daftar.blade.php                 # Menu 2: Form & Simulator IPK
│       └── hasil.blade.php                  # Menu 3: Tabel & Grafik Chart.js
├── routes/
│   └── web.php                              # Definisi rute web
└── tests/Feature/
    └── BeasiswaRegistrationTest.php         # Unit & Feature Test otomatis
```
