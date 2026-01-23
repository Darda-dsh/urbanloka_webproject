# 👑 URBANLOKA – Integrated Warehouse & POS System

**URBANLOKA** adalah aplikasi **Sistem Informasi Berbasis Website** yang mengintegrasikan **Warehouse Management System** dan **Point of Sale (POS)** untuk industri fashion urban.  
Project ini dikembangkan sebagai **Final Project** dan merupakan akumulasi pembelajaran **HTML, CSS, JavaScript, dan PHP Native**.

---

## 🎯 Tujuan Project

- Menerapkan konsep CRUD, Session, dan autentikasi.
- Mengimplementasikan relasi basis data MySQL minimal 5 tabel.
- Mengintegrasikan frontend dan backend tanpa framework PHP.
- Membuat sistem informasi yang fungsional, simetris, dan terstruktur.


## 🚀 Fitur Aplikasi

### 🔐 Autentikasi & Session
- **Login & Registrasi:** Pendaftaran dan autentikasi pengguna baru.
- **Session Role:** Pembatasan hak akses antara **Admin** (Full Access) dan **Kasir** (POS & History).

### 📦 Warehouse Management
- **Manajemen Produk:** Operasi CRUD untuk inventaris barang.
- **Kategori:** Pengelompokan produk secara dinamis.
- **File System:** Upload gambar produk otomatis dengan fitur *unlink* (hapus) file lama untuk efisiensi penyimpanan.

### 🧾 Point of Sale (POS)
- **Transaksi Real-time:** Pencarian produk dan transaksi cepat.
- **Cart System:** Keranjang belanja dinamis berbasis JavaScript.
- **Auto-Update Stok:** Stok produk berkurang otomatis saat checkout berhasil.

### 📊 Dashboard & Analytics
- **Business Metrics:** Total pendapatan, total stok aset, dan jumlah transaksi.
- **Visualisasi:** Tampilan ringkas performa bisnis secara real-time.

### 🌐 Website Publik & Profil
- **Public Profile:** Halaman identitas resmi perusahaan (Visi & Misi).
- **Featured Drops:** Menampilkan produk unggulan langsung dari database.
- **Dynamic Content:** Informasi kontak dan alamat yang dapat diubah melalui panel admin.

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** PHP Native (Versi 8.x)
- **Database:** MySQL (MariaDB)
- **Frontend:** - HTML5 
  - CSS3 (Custom Noir & Gold Theme)
  - JavaScript (ES6)
- **Library/UI:** - Bootstrap 5.3 
  - FontAwesome 6 


## 🗃️ Skema Basis Data

Database: **urbanloka_db** Jumlah tabel: **6 tabel berelasi**

1. **users:** Kredensial dan Role (Admin/Kasir).
2. **categories:** Data kategori fashion.
3. **products:** Inventaris barang *(Relasi ke categories)*.
4. **orders:** Header transaksi dan diskon.
5. **order_details:** Item per transaksi *(Relasi ke orders & products)*.
6. **company_profile:** Informasi profil perusahaan.

---

## 📂 Struktur Folder Project

```text
urbanloka/
├── assets/      # CSS, JS, dan UI Assets
├── config/      # database.php & helpers.php (Query Guard)
├── modules/     # Modul Inti (Analytics, Terminal POS, Warehouse)
├── partials/    # Header, Sidebar, Footer (Reusable)
├── public/      # Website publik (website.php)
├── uploads/     # Direktori gambar produk
└── urbanloka_db.sql # Database & Dummy Data
```

## ⚙️ Panduan Instalasi
1. Persiapan Environment
Pastikan Anda menggunakan web server lokal seperti Laragon (Direkomendasikan) atau XAMPP.

2. Setup Database
Buat database baru di phpMyAdmin dengan nama: urbanloka_db.

Import file urbanloka_db.sql yang tersedia di root folder.

3. Konfigurasi
Buka file config/database.php dan sesuaikan kredensial (host, username, password) sesuai dengan settingan server lokal Anda.

4. Akses Aplikasi
Dashboard & POS: http://localhost/urbanloka/

Website Publik: http://localhost/urbanloka/public/website.php

```

## 🔑 Akun Dummy (Untuk Testing)
- Admin: admin / admin123
- Kasir : kasir/kasir123