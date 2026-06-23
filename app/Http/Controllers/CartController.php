<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->cartFor($request);
        $cart->load('items.product.category');

        $total = $cart->items->sum(fn (CartItem $item): float => (float) $item->product->price * $item->quantity);

        return view('cart.index', compact('cart', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::query()
            ->where('is_active', true)
            ->findOrFail($validated['product_id']);

        $quantity = (int) $validated['quantity'];

        if ($product->stock < 1 || $quantity > $product->stock) {
            return back()->with('status', 'Stok produk tidak mencukupi.');
        }

        $cart = $this->cartFor($request);
        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $newQuantity = ((int) $item->quantity) + $quantity;

        if ($newQuantity > $product->stock) {
            return back()->with('status', 'Jumlah keranjang melebihi stok tersedia.');
        }

        $item->quantity = $newQuantity;
        $item->save();

        return redirect()->route('cart.index')->with('status', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($cartItem);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$cartItem->product->stock],
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return redirect()->route('cart.index')->with('status', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($cartItem);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('status', 'Produk berhasil dihapus dari keranjang.');
    }

    private function cartFor(Request $request): Cart
    {
        return $request->user()->cart()->firstOrCreate();
    }

    private function authorizeCartItem(CartItem $cartItem): void
    {
        abort_unless($cartItem->cart()->where('user_id', auth()->id())->exists(), 403);
    }
}
