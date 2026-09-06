# 🖊️ ChoiATK — E-Commerce & Management System Alat Tulis Kantor

**ChoiATK** adalah aplikasi berbasis web yang dirancang untuk mempermudah transaksi pemesanan alat tulis kantor (ATK) bagi pelanggan, sekaligus memberikan kontrol penuh bagi admin dalam mengelola inventaris produk dan pesanan secara efisien.

---

## 🚀 Fitur Utama

### 🛠️ Mode Admin
* **Dashboard Analitik:** Ringkasan total produk, pesanan masuk, dan peringatan otomatis untuk **stok menipis**.
* **Manajemen Produk (CRUD):** Tambah, edit, hapus, upload foto produk, dan batas minimum stok.
* **Instant Toggle Status:** Mengubah status aktif/nonaktif produk secara langsung dari tabel utama.
* **Manajemen Kategori:** Pengelompokan produk ATK (Buku, Alat Tulis, Kertas, dll).
* **Pengelolaan Pesanan:** Konfirmasi, proses, dan pembatalan pesanan dari pelanggan.

### 🛍️ Mode Pelanggan
* **Katalog Interaktif:** Menampilkan katalog produk yang terstruktur sesuai kategori.
* **Checkout & Pemesanan:** Alur belanja yang mudah dengan integrasi riwayat transaksi.
* **Aksesibel:** Katalog dapat dilihat tanpa ribet, dengan autentikasi aman saat transaksi.

---

## 🛠️ Teknologi yang Digunakan

* **Framework Backend:** [Laravel 11](https://laravel.com/)
* **Styling & UI:** [Tailwind CSS](https://tailwindcss.com/)
* **Interaktivitas:** [Alpine.js](https://alpinejs.dev/)
* **Database:** MySQL
* **Build Tool:** Vite

---

## 💻 Cara Menjalankan Proyek di Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Clone Repository
```bash
git clone https://github.com/Trezzal/ChoiATK.git
cd ChoiATK
```

### 2. Install Dependency
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan pengaturan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=choi_atk
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate App Key & Database Migration
```bash
php artisan key:generate
php artisan migrate --seed
```

### 5. Buat Symbolic Link Storage (Untuk Foto Produk)
```bash
php artisan storage:link
```

### 6. Jalankan Server
Buka dua terminal terpisah dan jalankan perintah berikut secara bersamaan:

* **Terminal 1 (Laravel Server):**
  ```bash
  php artisan serve
  ```
* **Terminal 2 (Vite Asset Compiler):**
  ```bash
  npm run dev
  ```

Aplikasi sekarang siap diakses melalui browser di: **http://127.0.0.1:8000**

---

## 👤 Pengembang
Dibuat oleh **Trezzal** untuk memenuhi tugas akhir kelas 11 smt 2 proyek aplikasi e-commerce & manajemen toko ATK.
