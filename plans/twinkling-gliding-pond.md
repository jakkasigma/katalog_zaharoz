# Rencana Implementasi: Payment Flow dengan QRIS dan Upload Bukti

## Konteks
User menginginkan alur pembayaran setelah checkout yang lebih informatif dan user-friendly:
1. Setelah Checkout, user diarahkan ke halaman detail pesanan.
2. Di halaman tersebut, tampilkan:
    - Total harga yang harus dibayar.
    - Gambar QRIS (bisa diatur admin).
    - Nomor rekening (bisa diatur admin).
    - Form upload bukti transfer.
3. Setelah upload, status pesanan menjadi `waiting_confirmation`.

## Rencana Pengerjaan
1. **Penyimpanan Info Pembayaran (Admin Setting):**
   - Menggunakan `CompanyProfile` yang sudah ada untuk menyimpan data QRIS path dan nomor rekening. Jika belum ada, akan ditambahkan kolomnya.

2. **Halaman Order Detail (`resources/views/orders/show.blade.php`):**
   - Update tampilan untuk menampilkan info pembayaran (QRIS, No. Rek, Total).
   - Tambahkan form upload bukti bayar (hanya tampil jika status pesanan `pending`).

3. **Controller (`PaymentController` atau `OrderController`):**
   - Tambahkan method untuk menangani upload bukti bayar dan update status pesanan menjadi `waiting_confirmation`.

4. **Testing & Verifikasi:**
   - Testing manual alur checkout sampai upload bukti bayar.
