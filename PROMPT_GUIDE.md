# Panduan Prompt AI - Tim Eyes of Zaharoz

Panduan ini berisi prompt siap pakai untuk setiap anggota tim. Copy-paste prompt sesuai tugas kamu ke Claude/AI, lalu ikuti hasilnya.

---

## Sebelum Mulai

1. Pastikan sudah `git pull origin main` dan buat branch sendiri (lihat `GIT_TUTORIAL.md`)
2. Pastikan `composer install` dan `npm install` sudah jalan
3. Pastikan database sudah di-migrate: `php artisan migrate`

---

## Anggota 1 — Frontend & Company Profile

### Branch: `feature/company-profile`

```bash
git checkout main
git pull origin main
git checkout -b feature/company-profile
```

### Prompt

```text
Kerjakan modul Frontend & Company Profile untuk project Laravel Blade Eyes of Zaharoz.

Baca file ini dulu:
- DESIGN_SYSTEM.md
- tugas_anggota.md
- workflow.md
- resources/css/app.css
- resources/views/components/ (semua file)
- resources/views/auth/login.blade.php (contoh referensi)
- resources/views/user/dashboard.blade.php (contoh referensi)

Tugas saya:
- Landing Page / Beranda
- Navbar & Footer (layout utama untuk public page)
- Halaman Tentang Kami
- Halaman Visi & Misi
- Halaman Kontak + integrasi Google Maps perusahaan
- Responsive Design (mobile wajib)

Wajib ikuti:
- tema black gothic clothing, background #000000, red/rose accent, sharp/no-radius
- public heading pakai font Viaoda Libre (uppercase, editorial)
- supporting serif Cinzel untuk nav / section title
- body text pakai Inter
- label teknis pakai JetBrains Mono
- pakai Blade components yang sudah ada: x-card, x-button, x-link-button, x-nav-link, x-page-header, x-alert
- Tailwind CSS v4, tanpa React/Vue/Inertia/Livewire
- buat controller dan views
- tambahkan route di routes/web.php
- konsisten dengan halaman auth/user yang sudah ada
- jalankan vendor/bin/pint --dirty sebelum selesai
- jalankan npm run build untuk memastikan frontend terbuild
```

### Checklist Selesai

- [ ] Landing page tampil dengan tema gothic
- [ ] Navbar & Footer konsisten di semua halaman public
- [ ] Halaman Tentang Kami lengkap
- [ ] Halaman Visi & Misi lengkap
- [ ] Halaman Kontak + Google Maps berfungsi
- [ ] Responsive di mobile
- [ ] `npm run build` sukses
- [ ] `php artisan test --compact` tidak error
- [ ] `vendor/bin/pint --dirty` sudah dijalankan
- [ ] Sudah push ke branch `feature/company-profile`

---

## Anggota 2 (Virgi) — Modul User & Authentication ✅ SELESAI

Modul ini sudah selesai di branch `auth` dan sudah di-merge ke `main`.

File yang sudah dibuat (bisa dijadikan referensi oleh anggota lain):

```
app/Http/Controllers/Auth/LoginController.php
app/Http/Controllers/Auth/RegisterController.php
app/Http/Controllers/User/DashboardController.php
app/Http/Controllers/User/ProfileController.php
app/Http/Controllers/User/AddressController.php
app/Http/Requests/
app/Models/User.php
app/Models/Address.php
database/migrations/0001_01_01_000000_create_users_table.php
database/migrations/2026_06_19_190601_create_addresses_table.php
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
resources/views/user/dashboard.blade.php
resources/views/user/profile/
resources/views/user/addresses/
resources/views/components/
resources/views/layouts/
```

---

## Anggota 3 — Modul Produk & Katalog

### Branch: `feature/produk`

```bash
git checkout main
git pull origin main
git checkout -b feature/produk
```

### Prompt

```text
Kerjakan modul Produk & Katalog untuk project Laravel Blade Eyes of Zaharoz.

Baca file ini dulu:
- DESIGN_SYSTEM.md
- tugas_anggota.md
- workflow.md
- resources/css/app.css
- resources/views/components/ (semua file)
- resources/views/auth/login.blade.php (contoh referensi form)
- resources/views/user/dashboard.blade.php (contoh referensi layout)
- resources/views/layouts/ (layout yang sudah ada)

Tugas saya:
- Kategori Produk (model, migration, seeder)
- Daftar Produk (halaman katalog dengan grid card)
- Detail Produk (halaman single produk)
- Pencarian Produk (search bar)
- Filter Produk (filter berdasarkan kategori)
- Keranjang Belanja / Cart (tambah, hapus, update qty)

Database yang perlu dibuat:
- categories (id, name, slug, description, image, timestamps)
- products (id, category_id, name, slug, description, price, stock, image, is_active, timestamps)
- carts (id, user_id, timestamps)
- cart_items (id, cart_id, product_id, quantity, timestamps)

Wajib ikuti:
- tema black gothic clothing, background #000000, red/rose accent, sharp/no-radius
- pakai Blade components: x-card, x-button, x-link-button, x-input, x-label, x-alert, x-page-header
- Tailwind CSS v4, tanpa React/Vue/Inertia/Livewire
- buat model dengan relationship, migration, factory, seeder
- buat controller (ProductController, CartController)
- buat views di resources/views/produk/ dan resources/views/cart/
- tambahkan route di routes/web.php
- buat test dengan Pest (php artisan make:test --pest)
- jalankan vendor/bin/pint --dirty sebelum selesai
- jalankan npm run build
- konsisten dengan halaman auth/user yang sudah ada
```

### Checklist Selesai

- [ ] Migration categories, products, carts, cart_items berhasil
- [ ] Model dengan relationship (Product belongsTo Category, dll)
- [ ] Factory & Seeder untuk data dummy
- [ ] Halaman katalog produk (grid card, responsive)
- [ ] Halaman detail produk
- [ ] Pencarian produk berfungsi
- [ ] Filter kategori berfungsi
- [ ] Keranjang belanja (tambah/hapus/update)
- [ ] Test Pest berjalan
- [ ] `npm run build` sukses
- [ ] `php artisan test --compact` tidak error
- [ ] `vendor/bin/pint --dirty` sudah dijalankan
- [ ] Sudah push ke branch `feature/produk`

---

## Anggota 4 — Modul Checkout & Transaksi

### Branch: `feature/checkout`

```bash
git checkout main
git pull origin main
git checkout -b feature/checkout
```

### Prompt

```text
Kerjakan modul Checkout & Transaksi untuk project Laravel Blade Eyes of Zaharoz.

Baca file ini dulu:
- DESIGN_SYSTEM.md
- tugas_anggota.md
- workflow.md
- resources/css/app.css
- resources/views/components/ (semua file)
- resources/views/user/dashboard.blade.php (contoh referensi)
- resources/views/user/addresses/ (referensi alamat pengiriman)
- resources/views/layouts/ (layout yang sudah ada)

Tugas saya:
- Checkout (pilih alamat pengiriman, review pesanan)
- Perhitungan total belanja (subtotal, total)
- Upload bukti transfer (tampilkan rekening perusahaan)
- Riwayat transaksi user
- Tracking status pesanan

Database yang perlu dibuat:
- orders (id, user_id, address_id, order_number, total_amount, status, notes, timestamps)
- order_items (id, order_id, product_id, product_name, product_price, quantity, subtotal, timestamps)
- payments (id, order_id, payment_proof, bank_name, account_name, amount, status, verified_at, timestamps)

Status pesanan yang harus didukung:
1. Menunggu Pembayaran
2. Menunggu Verifikasi
3. Pembayaran Ditolak
4. Pembayaran Diterima
5. Sedang Dikemas
6. Sedang Dikirim
7. Pesanan Selesai
8. Dibatalkan

Wajib ikuti:
- tema black gothic clothing, background #000000, red/rose accent, sharp/no-radius
- pakai Blade components: x-card, x-button, x-link-button, x-input, x-label, x-alert, x-page-header
- Tailwind CSS v4, tanpa React/Vue/Inertia/Livewire
- buat model dengan relationship, migration, factory, seeder
- buat controller (CheckoutController, OrderController, PaymentController)
- buat views di resources/views/checkout/ dan resources/views/orders/
- tambahkan route di routes/web.php
- buat test dengan Pest (php artisan make:test --pest)
- jalankan vendor/bin/pint --dirty sebelum selesai
- jalankan npm run build
- konsisten dengan halaman auth/user yang sudah ada

Catatan:
- Modul ini BERGANTUNG pada modul Produk (Anggota 3) untuk data cart
- Modul ini memakai tabel addresses yang sudah dibuat Anggota 2
- Jika modul produk belum selesai, buat migration & model dulu, nanti integrasikan setelah merge
```

### Checklist Selesai

- [ ] Migration orders, order_items, payments berhasil
- [ ] Model dengan relationship lengkap
- [ ] Factory & Seeder
- [ ] Halaman checkout (pilih alamat, review pesanan)
- [ ] Halaman upload bukti transfer
- [ ] Halaman riwayat transaksi
- [ ] Halaman tracking status pesanan
- [ ] Status pesanan berfungsi (8 status)
- [ ] Test Pest berjalan
- [ ] `npm run build` sukses
- [ ] `php artisan test --compact` tidak error
- [ ] `vendor/bin/pint --dirty` sudah dijalankan
- [ ] Sudah push ke branch `feature/checkout`

---

## Anggota 5 — Modul Admin Panel

### Branch: `feature/admin`

```bash
git checkout main
git pull origin main
git checkout -b feature/admin
```

### Prompt

```text
Kerjakan modul Admin Panel untuk project Laravel Blade Eyes of Zaharoz.

Baca file ini dulu:
- DESIGN_SYSTEM.md
- tugas_anggota.md
- workflow.md
- resources/css/app.css
- resources/views/components/ (semua file)
- resources/views/layouts/ (layout yang sudah ada)

Tugas saya:
- Login Admin (terpisah dari login user)
- Dashboard Admin (statistik ringkasan)
- Kelola Company Profile (CRUD tentang kami, visi misi, kontak, sosial media)
- Kelola Kategori Produk (CRUD)
- Kelola Produk (CRUD + upload gambar + kelola stok & harga)
- Kelola User (lihat, cari, aktifkan/nonaktifkan)
- Verifikasi Pembayaran (lihat bukti transfer, terima/tolak)
- Update Status Pesanan (update status + input resi)
- Laporan Penjualan (harian, bulanan, tahunan, produk terlaris)

Database yang perlu dibuat:
- admins (id, name, email, password, timestamps) — atau tambah kolom role di users
- Tabel lain mungkin sudah dibuat anggota lain (products, orders, payments)

Wajib ikuti:
- tema black gothic, admin boleh lebih padat dan table-friendly
- red/rose accent untuk tombol aksi dan verifikasi
- sharp/no-radius, high contrast
- Viaoda Libre hanya untuk title besar / branding di admin
- Inter untuk table, form, body text
- JetBrains Mono untuk status, kode, label kecil
- pakai Blade components: x-card, x-button, x-link-button, x-input, x-label, x-alert, x-page-header
- Tailwind CSS v4, tanpa React/Vue/Inertia/Livewire
- buat model, migration, factory, seeder
- buat controller di app/Http/Controllers/Admin/
- buat views di resources/views/admin/
- tambahkan route di routes/web.php (prefix 'admin', middleware admin)
- buat test dengan Pest (php artisan make:test --pest)
- jalankan vendor/bin/pint --dirty sebelum selesai
- jalankan npm run build
- konsisten dengan design system yang sudah ada

Catatan:
- Modul ini BERGANTUNG pada modul Produk (Anggota 3) dan Checkout (Anggota 4)
- Untuk kelola produk/kategori/pesanan/pembayaran, buat migration & model dulu jika belum ada
- Nanti integrasikan setelah modul lain di-merge ke main
```

### Checklist Selesai

- [ ] Login admin berfungsi (terpisah dari user)
- [ ] Dashboard admin dengan statistik
- [ ] CRUD Company Profile
- [ ] CRUD Kategori Produk
- [ ] CRUD Produk + upload gambar
- [ ] Kelola User (list, search, aktivasi)
- [ ] Verifikasi Pembayaran (terima/tolak)
- [ ] Update Status Pesanan + input resi
- [ ] Laporan Penjualan (minimal harian & bulanan)
- [ ] Middleware admin berfungsi
- [ ] Test Pest berjalan
- [ ] `npm run build` sukses
- [ ] `php artisan test --compact` tidak error
- [ ] `vendor/bin/pint --dirty` sudah dijalankan
- [ ] Sudah push ke branch `feature/admin`

---

## Catatan Penting untuk Semua Anggota

### Urutan Dependensi

```text
Anggota 1 (Company Profile)  → Independen, bisa mulai duluan
Anggota 2 (Auth)             → ✅ Sudah selesai
Anggota 3 (Produk)           → Independen, bisa mulai duluan
Anggota 4 (Checkout)         → Butuh modul Produk (Anggota 3) & Auth (Anggota 2)
Anggota 5 (Admin)            → Butuh modul Produk (3) & Checkout (4)
```

### Tips Jika Modul Lain Belum Selesai

Jika kamu butuh tabel/model dari anggota lain yang belum merge:

1. Buat migration & model sendiri dulu sebagai placeholder
2. Koordinasi dengan anggota terkait soal struktur tabel
3. Setelah modul lain merge ke main, pull dan sesuaikan

### Setelah Selesai Coding

```bash
# 1. Format kode PHP
vendor/bin/pint --dirty

# 2. Build frontend
npm run build

# 3. Jalankan test
php artisan test --compact

# 4. Commit & Push
git add .
git commit -m "feat: deskripsi modul yang dikerjakan"
git push origin feature/nama-branch

# 5. Buat Pull Request di GitHub
#    Base: main
#    Compare: feature/nama-branch
```

### File yang Rawan Konflik

File-file ini kemungkinan diedit banyak anggota. Komunikasikan jika mengubahnya:

| File | Siapa yang mungkin edit |
| --- | --- |
| `routes/web.php` | Semua anggota |
| `resources/css/app.css` | Anggota 1, 3, 5 |
| `resources/views/layouts/` | Anggota 1, 5 |
| `database/seeders/DatabaseSeeder.php` | Semua anggota |

### Prompt Tambahan Jika Butuh Lanjutan

Jika prompt pertama belum selesai semua, lanjutkan dengan:

```text
Lanjutkan modul [NAMA MODUL] yang tadi.

Yang sudah selesai:
- [list yang sudah dibuat]

Yang belum:
- [list yang belum]

Tetap ikuti DESIGN_SYSTEM.md dan pakai Blade components yang sudah ada.
```

### Prompt Jika Ada Bug / Error

```text
Saya mendapat error berikut di modul [NAMA MODUL]:

[paste error message]

File terkait:
- [nama file]

Tolong perbaiki. Tetap ikuti DESIGN_SYSTEM.md.
```
