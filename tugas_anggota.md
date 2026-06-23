# Pembagian Tugas Tim (5 Orang)

> Catatan desain: Semua anggota wajib mengikuti `DESIGN_SYSTEM.md` dan memakai Blade components di `resources/views/components` agar tampilan konsisten.

## Anggota 1 - Frontend & Company Profile

### Tanggung Jawab

* Membuat tampilan website (User Side)
* Landing Page
* Navbar & Footer
* Halaman Beranda
* Halaman Tentang Kami
* Halaman Visi & Misi
* Halaman Kontak
* Integrasi Google Maps perusahaan
* Responsive Design

### Output

* UI/UX Company Profile
* Halaman Informasi Perusahaan
* Komponen Layout Utama

---

## Anggota 2 (virgi)- Modul User & Authentication ✅ SELESAI

### Tanggung Jawab

* [x] Registrasi User
* [x] Login User
* [x] Logout User
* [x] Middleware User
* [x] Profil User
* [x] Edit Profil
* [x] Ganti Password
* [x] Kelola Alamat Pengiriman + Map Picker

### Database

* [x] users
* [x] user_profiles — digabung ke tabel `users` (`phone`, `profile_photo_path`) agar tidak duplikasi data profil
* [x] addresses

### Output

* [x] Sistem autentikasi
* [x] Dashboard User
* [x] Manajemen Profil

---

## Anggota 3 - Modul Produk & Katalog ✅ SELESAI

### Tanggung Jawab

* [x] Kategori Produk
* [x] Daftar Produk
* [x] Detail Produk
* [x] Pencarian Produk
* [x] Filter Produk
* [x] Keranjang Belanja (Cart)

### Database

* [x] categories
* [x] products
* [x] carts
* [x] cart_items

### Output

* [x] Katalog Produk
* [x] Detail Produk
* [x] Sistem Keranjang

### Verifikasi

* [x] `vendor/bin/pint --dirty --format agent` berhasil
* [x] `php artisan migrate:fresh --seed --no-interaction` berhasil
* [x] `npm run build` berhasil
* [x] `php artisan test --compact` berhasil — 21 tests, 65 assertions
* [x] Sudah commit dan push ke `origin/branch-tugas_anggota_3`

---

## Anggota 4 - Modul Checkout & Transaksi

### Tanggung Jawab

* Checkout
* Pemilihan Alamat
* Perhitungan Total Belanja
* Upload Bukti Transfer
* Riwayat Transaksi
* Tracking Status Pesanan

### Database

* orders
* order_items
* payments

### Output

* Sistem Checkout
* Upload Bukti Pembayaran
* Riwayat Pesanan User

---

## Anggota 5 - Modul Admin Panel

### Tanggung Jawab

* Dashboard Admin
* Kelola Company Profile
* Kelola Produk
* Kelola Kategori
* Kelola User
* Verifikasi Pembayaran
* Update Status Pesanan
* Laporan Penjualan

### Database

* admin
* reports

### Output

* Admin Dashboard
* Sistem Verifikasi Pembayaran
* Laporan Penjualan
