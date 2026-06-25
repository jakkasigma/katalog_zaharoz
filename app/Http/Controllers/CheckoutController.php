<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\UploadPaymentProofRequest;
use App\Models\CompanyProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Step 1 — Tampil form checkout (alamat + catatan).
     */
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->addresses()->count() === 0) {
            return redirect()->route('addresses.create')
                ->with('status', 'Tambahkan alamat pengiriman terlebih dahulu untuk melanjutkan checkout.');
        }

        $cart = $user->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('status', 'Keranjang belanja kamu kosong.');
        }

        $addresses = $user->addresses()->get();
        $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();
        $subtotal = $cart->items->sum(fn ($item) => (float) $item->product->price * $item->quantity);

        return view('checkout.index', compact('addresses', 'defaultAddress', 'cart', 'subtotal'));
    }

    /**
     * Step 1 POST — Validasi, simpan ke session, redirect ke halaman pembayaran.
     * Order belum dibuat di sini.
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $validated = $request->validated();

        $cart = $user->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('status', 'Keranjang belanja kamu kosong.');
        }

        // Validasi stok
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->withInput()->with('error',
                    "Stok produk \"{$item->product->name}\" tidak mencukupi. Tersisa {$item->product->stock} item."
                );
            }
        }

        // Simpan data checkout ke session — order belum dibuat
        session([
            'checkout' => [
                'address_id' => $validated['address_id'],
                'notes' => $validated['notes'] ?? null,
            ],
        ]);

        return redirect()->route('checkout.payment');
    }

    /**
     * Step 2 — Tampil halaman pembayaran (QRIS + rekening + form upload bukti).
     */
    public function payment(): View|RedirectResponse
    {
        // Pastikan session checkout ada
        if (! session()->has('checkout')) {
            return redirect()->route('checkout.index')
                ->with('status', 'Silakan lengkapi data checkout terlebih dahulu.');
        }

        $user = auth()->user();
        $cart = $user->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            session()->forget('checkout');

            return redirect()->route('cart.index')
                ->with('status', 'Keranjang belanja kamu kosong.');
        }

        $subtotal = $cart->items->sum(fn ($item) => (float) $item->product->price * $item->quantity);
        $companyProfile = CompanyProfile::query()->first();

        return view('checkout.payment', compact('cart', 'subtotal', 'companyProfile'));
    }

    /**
     * Step 2 POST — Upload bukti, baru buat order + order_items + kurangi stok.
     */
    public function confirm(UploadPaymentProofRequest $request): RedirectResponse
    {
        if (! session()->has('checkout')) {
            return redirect()->route('checkout.index')
                ->with('status', 'Sesi checkout sudah berakhir. Silakan ulangi.');
        }

        $user = auth()->user();
        $checkoutData = session('checkout');
        $cart = $user->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            session()->forget('checkout');

            return redirect()->route('cart.index')
                ->with('status', 'Keranjang belanja kamu kosong.');
        }

        // Validasi stok sekali lagi (bisa berubah sejak step 1)
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error',
                    "Stok produk \"{$item->product->name}\" tidak mencukupi. Tersisa {$item->product->stock} item."
                );
            }
        }

        try {
            DB::beginTransaction();

            $subtotal = $cart->items->sum(fn ($item) => (float) $item->product->price * $item->quantity);
            $orderNumber = 'ORD-'.strtoupper(str()->random(4)).date('ymd').strtoupper(str()->random(4));

            // Buat order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'address_id' => $checkoutData['address_id'],
                'status' => 'pending',
                'payment_status' => 'waiting_confirmation',
                'subtotal' => $subtotal,
                'shipping_cost' => 0,
                'total' => $subtotal,
                'notes' => $checkoutData['notes'],
            ]);

            // Salin cart items → order_items & kurangi stok
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'unit_price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => (float) $item->product->price * $item->quantity,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Simpan bukti pembayaran
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'method' => 'transfer',
                'status' => 'waiting_confirmation',
                'proof_path' => $proofPath,
            ]);

            // Kosongkan keranjang & session
            $cart->items()->delete();
            session()->forget('checkout');

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('status', 'Pembayaran berhasil diupload! Pesanan sedang dikonfirmasi admin.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
