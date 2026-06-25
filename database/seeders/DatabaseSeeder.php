<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->admin()->create([
            'name' => 'Admin Eyes',
            'email' => 'admin@eyes.test',
        ]);

        $categories = collect([
            ['name' => 'Outerwear', 'description' => 'Jaket dan mantel gothic untuk siluet malam.', 'sort_order' => 1],
            ['name' => 'Shirts', 'description' => 'Atasan hitam dengan potongan tajam dan aksen merah.', 'sort_order' => 2],
            ['name' => 'Accessories', 'description' => 'Aksesori ritual untuk melengkapi pakaian.', 'sort_order' => 3],
            ['name' => 'Boots', 'description' => 'Sepatu boots kokoh untuk langkah gelap.', 'sort_order' => 4],
        ])->map(fn (array $category): Category => Category::query()->create([
            'name' => $category['name'],
            'slug' => Str::slug($category['name']),
            'description' => $category['description'],
            'is_active' => true,
            'sort_order' => $category['sort_order'],
        ]));

        $products = [
            ['Outerwear', 'Crimson Veil Long Coat', 875000, 9],
            ['Outerwear', 'Black Thorn Cropped Jacket', 620000, 12],
            ['Shirts', 'Rose Ritual Oversized Shirt', 325000, 18],
            ['Shirts', 'Nocturne Mesh Layer Top', 280000, 15],
            ['Accessories', 'Blood Moon Chain Choker', 185000, 25],
            ['Accessories', 'Zaharoz Sigil Belt', 240000, 20],
            ['Boots', 'Obsidian Platform Boots', 1150000, 6],
            ['Boots', 'Gravewalk Buckle Boots', 980000, 8],
        ];

        foreach ($products as $index => [$categoryName, $name, $price, $stock]) {
            $category = $categories->firstWhere('name', $categoryName);

            Product::query()->create([
                'category_id' => $category?->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'sku' => 'EOZ-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                'description' => 'Koleksi '.$name.' membawa nuansa black gothic clothing dengan garis tegas, warna gelap, dan aksen rose yang dramatis.',
                'image_path' => null,
                'price' => $price,
                'stock' => $stock,
                'is_active' => true,
            ]);
        }
    }
}
