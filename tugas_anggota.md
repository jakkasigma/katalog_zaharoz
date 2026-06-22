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

## Anggota 3 - Modul Produk & Katalog

### Tanggung Jawab

* Kategori Produk
* Daftar Produk
* Detail Produk
* Pencarian Produk
* Filter Produk
* Keranjang Belanja (Cart)

### Database

* categories
* products
* carts
* cart_items

### Output

* Katalog Produk
* Detail Produk
* Sistem Keranjang

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
