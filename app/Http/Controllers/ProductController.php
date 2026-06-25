<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function storefront(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $categorySlug = $request->string('category')->trim()->toString();

        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug !== '', function ($query) use ($categorySlug): void {
                $query->whereHas('category', function ($query) use ($categorySlug): void {
                    $query->where('slug', $categorySlug)->where('is_active', true);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('store.index', compact('products', 'categories', 'search', 'categorySlug'));
    }

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $categorySlug = $request->string('category')->trim()->toString();

        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug !== '', function ($query) use ($categorySlug): void {
                $query->whereHas('category', function ($query) use ($categorySlug): void {
                    $query->where('slug', $categorySlug)->where('is_active', true);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('products.index', compact('products', 'categories', 'search', 'categorySlug'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load('category');

        $relatedProducts = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->whereKeyNot($product->id)
            ->when($product->category_id, function ($query) use ($product): void {
                $query->where('category_id', $product->category_id);
            })
            ->latest()
            ->limit(3)
            ->get();

        return view('store.show', compact('product', 'relatedProducts'));
    }
}
