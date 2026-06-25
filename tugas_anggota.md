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

## Anggota 4 - Modul Checkout & Transaksi ✅ SELESAI

### Tanggung Jawab

* [x] Checkout
* [x] Pemilihan Alamat
* [x] Perhitungan Total Belanja
* [x] Upload Bukti Transfer
* [x] Riwayat Transaksi
* [x] Tracking Status Pesanan

### Database

* [x] orders
* [x] order_items
* [x] payments

### Output

* [x] Sistem Checkout
* [x] Upload Bukti Pembayaran
* [x] Riwayat Pesanan User

### File yang Sudah Dibuat

```
app/Http/Controllers/CheckoutController.php
app/Http/Controllers/OrderController.php
app/Http/Controllers/PaymentController.php
app/Http/Requests/CheckoutRequest.php
app/Http/Requests/UploadPaymentProofRequest.php
app/Policies/OrderPolicy.php
database/factories/AddressFactory.php
database/factories/OrderFactory.php
database/factories/OrderItemFactory.php
database/factories/PaymentFactory.php
database/migrations/2026_06_23_092002_add_address_and_notes_to_orders_table.php
database/seeders/OrderSeeder.php
resources/views/checkout/index.blade.php
resources/views/orders/index.blade.php
resources/views/orders/show.blade.php
resources/views/payments/create.blade.php
tests/Feature/CheckoutTest.php
tests/Feature/OrderTest.php
tests/Feature/PaymentTest.php
```

---

## Anggota 5 - Modul Admin Panel 🔄 IN PROGRESS (90%)

### Tanggung Jawab

* [x] Dashboard Admin
* [x] Kelola Company Profile
* [x] Kelola Produk
* [x] Kelola Kategori
* [x] Kelola User
* [x] Verifikasi Pembayaran
* [x] Update Status Pesanan
* [x] Laporan Penjualan

### Database

* [x] admin (menggunakan field `is_admin` di tabel users)
* [x] company_profiles
* [x] menggunakan tabel products, categories, orders, payments yang sudah ada

### Output

* [x] Admin Dashboard
* [x] Sistem Verifikasi Pembayaran
* [x] Laporan Penjualan

### Status

* ✅ Semua controllers dibuat (8 controllers)
* ✅ Semua requests dibuat (7 request classes)
* ✅ Semua views dibuat (18+ blade files)
* ✅ Semua routes terkonfigurasi
* ✅ Middleware admin dibuat (`EnsureUserIsAdmin`)
* ✅ Admin tests dibuat (8 test files)
* ✅ Tests passing (36 admin tests passed)
* ❌ Belum di-commit dan push (masih untracked files)
* ⚠️ Perlu manual testing untuk verifikasi UI/UX

### File yang Sudah Dibuat

```
app/Http/Controllers/Admin/CategoryController.php
app/Http/Controllers/Admin/CompanyProfileController.php
app/Http/Controllers/Admin/DashboardController.php
app/Http/Controllers/Admin/OrderController.php
app/Http/Controllers/Admin/PaymentVerificationController.php
app/Http/Controllers/Admin/ProductController.php
app/Http/Controllers/Admin/ReportController.php
app/Http/Controllers/Admin/UserController.php
app/Http/Requests/Admin/* (7 files)
resources/views/admin/** (18+ files)
tests/Feature/Admin/* (8 files)
```
