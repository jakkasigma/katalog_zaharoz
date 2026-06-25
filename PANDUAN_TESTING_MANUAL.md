# Panduan Manual Testing - Eyes Zaharoz

> **Status Proyek**: 90-94% Selesai  
> **Automated Tests**: 84 passed, 1 failed (PaymentTest - minor issue)  
> **Last Updated**: 2026-06-24

---

## 📋 Daftar Isi

1. [Prerequisites](#prerequisites)
2. [Test Credentials](#test-credentials)
3. [User Testing Scenarios](#user-testing-scenarios)
4. [Admin Testing Scenarios](#admin-testing-scenarios)
5. [Known Issues](#known-issues)

---

## Prerequisites

Sebelum memulai testing, pastikan:

1. **MySQL Server Running**
   ```bash
   # Check MySQL status
   # Pastikan MySQL service sudah aktif
   ```

2. **Database Setup**
   ```bash
   php artisan migrate:fresh --seed --no-interaction
   ```

3. **Development Server Running**
   ```bash
   # Terminal 1: Backend
   php artisan serve
   # URL: http://localhost:8000
   
   # Terminal 2: Frontend (jika diperlukan)
   npm run dev
   ```

4. **Test Data Available**
   - Seeder akan membuat dummy data untuk products, categories, users, dan orders
   - Admin user akan dibuat otomatis oleh seeder

---

## Test Credentials

### User Test Accounts

Setelah menjalankan seeder, gunakan credentials berikut:

**Regular User 1:**
- Email: `test@example.com`
- Password: `password`

**Regular User 2:**
- Email: `user2@example.com`
- Password: `password`

### Admin Test Account

**Admin:**
- Email: `admin@example.com`
- Password: `password`
- Role: Administrator

> **Note**: Jika credentials di atas tidak bekerja, cek file `database/seeders/DatabaseSeeder.php` untuk melihat credentials yang sebenarnya dibuat.

---

## User Testing Scenarios

### 1. Registrasi & Login

#### Test Case 1.1: User Registrasi Berhasil
**Steps:**
1. Buka `http://localhost:8000`
2. Klik link "Register" atau navigasi ke `/register`
3. Isi form registrasi:
   - Name: `Test User`
   - Email: `testuser@example.com`
   - Phone: `081234567890`
   - Password: `password123`
   - Password Confirmation: `password123`
4. Klik tombol "Register"

**Expected Result:**
- ✅ Redirect ke dashboard user (`/dashboard`)
- ✅ User berhasil login otomatis
- ✅ Muncul notifikasi sukses
- ✅ Data user tersimpan di database tabel `users`

**How to Verify:**
```bash
php artisan tinker --execute 'User::where("email", "testuser@example.com")->first();'
```

---

#### Test Case 1.2: User Login Berhasil
**Steps:**
1. Logout dari akun saat ini (jika sudah login)
2. Navigasi ke `/login`
3. Isi form login:
   - Email: `test@example.com`
   - Password: `password`
4. Klik tombol "Login"

**Expected Result:**
- ✅ Redirect ke dashboard user (`/dashboard`)
- ✅ Session berhasil dibuat
- ✅ User dapat melihat informasi dashboard

---

#### Test Case 1.3: Login dengan Credentials Salah
**Steps:**
1. Navigasi ke `/login`
2. Isi form dengan password yang salah:
   - Email: `test@example.com`
   - Password: `wrongpassword`
3. Klik tombol "Login"

**Expected Result:**
- ❌ Login gagal
- ✅ Muncul error message: "These credentials do not match our records"
- ✅ User tetap di halaman login

---

### 2. Profile Management

#### Test Case 2.1: Update Profil User
**Steps:**
1. Login sebagai user biasa
2. Navigasi ke `/profile`
3. Edit informasi profil:
   - Name: `Updated Name`
   - Email: `newemail@example.com`
   - Phone: `087654321098`
4. Klik "Save Changes"

**Expected Result:**
- ✅ Data berhasil diupdate di database
- ✅ Muncul notifikasi sukses
- ✅ Perubahan terlihat di form profil

---

#### Test Case 2.2: Ganti Password
**Steps:**
1. Login sebagai user biasa
2. Navigasi ke `/profile/password`
3. Isi form ganti password:
   - Current Password: `password`
   - New Password: `newpassword123`
   - Confirm New Password: `newpassword123`
4. Klik "Change Password"

**Expected Result:**
- ✅ Password berhasil diupdate
- ✅ Muncul notifikasi sukses
- ✅ User dapat login dengan password baru

**How to Verify:**
- Logout dan coba login dengan password baru

---

#### Test Case 2.3: Upload Profile Photo
**Steps:**
1. Login sebagai user biasa
2. Navigasi ke `/profile`
3. Klik tombol "Upload Photo"
4. Pilih image file (JPG/PNG, max 2MB)
5. Submit form

**Expected Result:**
- ✅ Photo berhasil diupload ke `storage/app/public/profile-photos/`
- ✅ Photo ditampilkan di halaman profil
- ✅ Field `profile_photo_path` di database terupdate

---

### 3. Address Management

#### Test Case 3.1: Tambah Alamat Baru
**Steps:**
1. Login sebagai user biasa
2. Navigasi ke `/addresses`
3. Klik "Add New Address"
4. Isi form alamat:
   - Recipient Name: `John Doe`
   - Phone: `081234567890`
   - Province: `Jawa Barat`
   - City: `Bandung`
   - District: `Coblong`
   - Postal Code: `40132`
   - Full Address: `Jl. Dipatiukur No. 35`
   - Latitude: `-6.8915` (dari map picker atau manual)
   - Longitude: `107.6107` (dari map picker atau manual)
   - Default Address: ✅ (checked)
5. Klik "Save Address"

**Expected Result:**
- ✅ Alamat tersimpan di database tabel `addresses`
- ✅ Redirect ke halaman daftar alamat
- ✅ Alamat baru muncul di list
- ✅ Badge "Default" muncul jika set sebagai default

---

#### Test Case 3.2: Edit Alamat Existing
**Steps:**
1. Navigasi ke `/addresses`
2. Klik tombol "Edit" pada salah satu alamat
3. Ubah informasi (misalnya ganti recipient name)
4. Klik "Update Address"

**Expected Result:**
- ✅ Data alamat terupdate di database
- ✅ Perubahan terlihat di daftar alamat

---

#### Test Case 3.3: Hapus Alamat
**Steps:**
1. Navigasi ke `/addresses`
2. Klik tombol "Delete" pada alamat yang bukan default
3. Konfirmasi penghapusan

**Expected Result:**
- ✅ Alamat terhapus dari database
- ✅ Alamat hilang dari list
- ✅ Muncul notifikasi sukses

---

#### Test Case 3.4: Set Alamat Sebagai Default
**Steps:**
1. Navigasi ke `/addresses`
2. Pada alamat yang bukan default, klik "Set as Default"

**Expected Result:**
- ✅ Alamat terpilih menjadi default (field `is_default` = true)
- ✅ Alamat yang sebelumnya default menjadi non-default
- ✅ Badge "Default" berpindah ke alamat baru

---

### 4. Product Browsing & Search

#### Test Case 4.1: Lihat Katalog Produk
**Steps:**
1. Navigasi ke `/products`

**Expected Result:**
- ✅ Menampilkan grid/list produk yang aktif
- ✅ Setiap produk menampilkan: foto, nama, harga, stock status
- ✅ Produk yang inactive tidak ditampilkan
- ✅ Pagination berfungsi jika produk > 12 items

---

#### Test Case 4.2: Search Produk by Name
**Steps:**
1. Navigasi ke `/products`
2. Di search box, ketik nama produk (contoh: `laptop`)
3. Tekan Enter atau klik Search

**Expected Result:**
- ✅ Menampilkan produk yang mengandung keyword "laptop" di name/description/sku
- ✅ URL berubah menjadi `/products?search=laptop`
- ✅ Result count ditampilkan

---

#### Test Case 4.3: Filter Produk by Category
**Steps:**
1. Navigasi ke `/products`
2. Klik salah satu kategori dari sidebar/filter
3. Misal klik kategori "Electronics"

**Expected Result:**
- ✅ Hanya menampilkan produk dari kategori terpilih
- ✅ URL berubah menjadi `/products?category=electronics` (slug)
- ✅ Active category ditandai/highlight

---

#### Test Case 4.4: View Product Detail
**Steps:**
1. Navigasi ke `/products`
2. Klik salah satu produk

**Expected Result:**
- ✅ Redirect ke `/products/{slug}`
- ✅ Menampilkan detail lengkap: nama, harga, deskripsi, stok, foto
- ✅ Tombol "Add to Cart" muncul (jika user login)
- ✅ Quantity selector muncul

---

### 5. Cart Management

#### Test Case 5.1: Tambah Produk ke Cart
**Steps:**
1. Login sebagai user
2. Navigasi ke detail produk `/products/{slug}`
3. Pilih quantity (contoh: 2)
4. Klik "Add to Cart"

**Expected Result:**
- ✅ Item masuk ke tabel `cart_items`
- ✅ Muncul notifikasi sukses
- ✅ Cart badge/counter bertambah (jika ada)
- ✅ Redirect atau stay di halaman produk

---

#### Test Case 5.2: View Cart
**Steps:**
1. Login sebagai user yang sudah punya cart items
2. Navigasi ke `/cart`

**Expected Result:**
- ✅ Menampilkan daftar produk di cart
- ✅ Setiap item menampilkan: foto, nama, harga, quantity, subtotal
- ✅ Total cart price ditampilkan di bagian bawah
- ✅ Tombol "Checkout" muncul

---

#### Test Case 5.3: Update Quantity di Cart
**Steps:**
1. Navigasi ke `/cart`
2. Ubah quantity salah satu item (contoh: dari 2 jadi 3)
3. Klik "Update" atau auto-update jika menggunakan AJAX

**Expected Result:**
- ✅ Quantity terupdate di database
- ✅ Subtotal item terupdate
- ✅ Total cart price terupdate
- ✅ Muncul notifikasi sukses

---

#### Test Case 5.4: Hapus Item dari Cart
**Steps:**
1. Navigasi ke `/cart`
2. Klik tombol "Remove" pada salah satu item

**Expected Result:**
- ✅ Item terhapus dari `cart_items`
- ✅ Item hilang dari tampilan cart
- ✅ Total cart price terupdate
- ✅ Muncul notifikasi sukses

---

### 6. Checkout Process

#### Test Case 6.1: Checkout dengan Alamat Default
**Steps:**
1. Login sebagai user yang punya cart items dan alamat
2. Navigasi ke `/cart`
3. Klik tombol "Proceed to Checkout"
4. Di halaman checkout, pastikan alamat default sudah terpilih
5. Isi notes (optional): `Tolong kirim pagi hari`
6. Klik "Place Order"

**Expected Result:**
- ✅ Order baru dibuat di tabel `orders` dengan status `pending_payment`
- ✅ Order items dibuat di tabel `order_items`
- ✅ Cart items terhapus setelah checkout
- ✅ Redirect ke halaman order detail `/orders/{id}`
- ✅ Menampilkan informasi pembayaran (rekening bank)

---

#### Test Case 6.2: Checkout Pilih Alamat Lain
**Steps:**
1. Di halaman checkout `/checkout`
2. Klik "Change Address" atau pilih alamat lain dari dropdown
3. Pilih alamat pengiriman yang berbeda
4. Klik "Place Order"

**Expected Result:**
- ✅ Order menggunakan alamat yang dipilih (bukan default)
- ✅ Field `address_*` di tabel `orders` berisi data alamat terpilih

---

#### Test Case 6.3: Checkout tanpa Alamat
**Steps:**
1. Login sebagai user BARU yang belum punya alamat
2. Tambah produk ke cart
3. Coba checkout

**Expected Result:**
- ❌ Checkout tidak bisa dilanjutkan
- ✅ Muncul pesan: "Please add a shipping address first"
- ✅ Link/button untuk "Add Address" tersedia

---

### 7. Payment Upload & Order Tracking

#### Test Case 7.1: Upload Bukti Transfer
**Steps:**
1. Login sebagai user yang punya order dengan status `pending_payment`
2. Navigasi ke `/orders`
3. Klik order yang pending payment
4. Klik tombol "Upload Payment Proof"
5. Upload gambar bukti transfer (JPG/PNG, max 2MB)
6. Klik "Submit Payment Proof"

**Expected Result:**
- File terupload ke `storage/app/public/payments/`
- Record payment dibuat di tabel `payments` dengan status `pending_verification`
- Order status tetap `pending_payment` (menunggu admin verifikasi)
- Muncul notifikasi sukses

#### Test Case 7.2: View Order Detail
**Steps:**
1. Login sebagai user
2. Navigasi ke `/orders`
3. Klik salah satu order untuk view detail

**Expected Result:**
- Menampilkan order number, date, status
- Menampilkan list order items (product, quantity, price, subtotal)
- Menampilkan shipping address
- Menampilkan total amount
- Menampilkan payment status

---

## Admin Testing Scenarios

### 8. Admin Login & Authentication

#### Test Case 8.1: Admin Login Berhasil
**Steps:**
1. Navigasi ke `/admin/login`
2. Isi form login dengan admin credentials
3. Klik "Login"

**Expected Result:**
- Redirect ke admin dashboard `/admin/dashboard`
- Admin session dibuat
- Middleware `admin` memverifikasi `is_admin = true`

#### Test Case 8.2: Non-Admin User Tidak Bisa Akses Admin
**Steps:**
1. Login sebagai user biasa (non-admin)
2. Coba akses `/admin/dashboard` manually

**Expected Result:**
- Access denied
- Redirect ke homepage atau 403 forbidden

---

### 9. Admin Dashboard

#### Test Case 9.1: View Dashboard Stats
**Steps:**
1. Login sebagai admin
2. View dashboard `/admin/dashboard`

**Expected Result:**
- Menampilkan total users count
- Menampilkan total products count
- Menampilkan total orders count
- Menampilkan pending payments count

---

### 10. Company Profile Management

#### Test Case 10.1: Update Company Profile
**Steps:**
1. Login sebagai admin
2. Navigasi ke `/admin/company-profile`
3. Edit informasi company profile
4. Klik "Save Changes"

**Expected Result:**
- Data terupdate di tabel `company_profiles`
- Muncul notifikasi sukses

---

### 11. Category Management

#### Test Case 11.1: View Categories List
**Steps:**
1. Login sebagai admin
2. Navigasi ke `/admin/categories`

**Expected Result:**
- Menampilkan table list categories
- Tombol "Add Category" tersedia

#### Test Case 11.2: Create New Category
**Steps:**
1. Di halaman `/admin/categories`
2. Klik "Add Category"
3. Isi form (Name, Description)
4. Klik "Save"

**Expected Result:**
- Category baru tersimpan di tabel `categories`
- Slug auto-generate
- Category baru muncul di list

#### Test Case 11.3: Delete Category
**Steps:**
1. Coba hapus category yang tidak punya products
2. Konfirmasi penghapusan

**Expected Result:**
- Category terhapus dari database

---

### 12. Product Management

#### Test Case 12.1: View Products List
**Steps:**
1. Login sebagai admin
2. Navigasi ke `/admin/products`

**Expected Result:**
- Menampilkan table list products
- Tombol "Add Product" tersedia

#### Test Case 12.2: Create New Product
**Steps:**
1. Klik "Add Product"
2. Isi form (Name, SKU, Category, Price, Stock, Description)
3. Upload product image
4. Klik "Save"

**Expected Result:**
- Product tersimpan di tabel `products`
- Image terupload ke storage

#### Test Case 12.3: Edit Product
**Steps:**
1. Klik "Edit" pada product
2. Ubah price dan stock
3. Klik "Update"

**Expected Result:**
- Data terupdate di database

---

### 13. User Management

#### Test Case 13.1: View Users List
**Steps:**
1. Login sebagai admin
2. Navigasi ke `/admin/users`

**Expected Result:**
- Menampilkan table list users

#### Test Case 13.2: Toggle User Active Status
**Steps:**
1. Di halaman user detail
2. Klik "Deactivate User"

**Expected Result:**
- Field `is_active` berubah menjadi `false`
- User tidak bisa login

---

### 14. Payment Verification

#### Test Case 14.1: View Pending Payments
**Steps:**
1. Login sebagai admin
2. Navigasi ke `/admin/payments`

**Expected Result:**
- Menampilkan list payments dengan status `pending_verification`

#### Test Case 14.2: Approve Payment
**Steps:**
1. Di halaman payment detail
2. Klik tombol "Approve"
3. Konfirmasi approval

**Expected Result:**
- Payment status berubah menjadi `verified`
- Order status berubah menjadi `processing`

#### Test Case 14.3: Reject Payment
**Steps:**
1. Klik tombol "Reject"
2. Isi reason for rejection
3. Konfirmasi rejection

**Expected Result:**
- Payment status berubah menjadi `rejected`
- Customer bisa upload bukti transfer baru

---

### 15. Order Management

#### Test Case 15.1: View Orders List
**Steps:**
1. Login sebagai admin
2. Navigasi ke `/admin/orders`

**Expected Result:**
- Menampilkan table list all orders

#### Test Case 15.2: Update Order Status to Shipped
**Steps:**
1. Di halaman order detail
2. Update status ke `shipped`
3. Isi tracking number
4. Klik "Update Status"

**Expected Result:**
- Order status berubah menjadi `shipped`
- Tracking number tersimpan

---

### 16. Reports & Analytics

#### Test Case 16.1: View Sales Report
**Steps:**
1. Login sebagai admin
2. Navigasi ke `/admin/reports`

**Expected Result:**
- Menampilkan sales statistics
- Total revenue
- Total orders count

---

## Known Issues

### 1. PaymentTest Failing
**Issue:** Test `user can upload payment proof` gagal

**Status:** Need Investigation

---

### 2. Admin Panel Files Not Committed
**Issue:** Admin panel files belum di-commit dan push

**Status:** In Progress (Anggota 5)

---

## Summary & Next Steps

### Completed (94%)
1. User Registration & Authentication
2. Profile & Address Management
3. Product Catalog & Search
4. Shopping Cart
5. Checkout Process
6. Payment Upload
7. Order Tracking
8. Admin Panel Structure

### In Progress (6%)
1. Fix PaymentTest failure
2. Commit & push Admin Panel files
3. Manual testing verification

### Testing Checklist
- [ ] Run all user flow scenarios
- [ ] Run all admin flow scenarios
- [ ] Fix 1 failing test
- [ ] Cross-browser testing
- [ ] Mobile responsive testing

---

**Last Updated:** 2026-06-24
**Project Completion:** 90-94%
**Automated Tests:** 84 passed, 1 failed
