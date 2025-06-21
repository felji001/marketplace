<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get users
        $producer1 = User::where('email', 'fatyelouardi@gmail.com')->first();
        $producer2 = User::where('email', 'ahmed.producer@gmail.com')->first();

        // Get categories
        $electronics = Category::where('slug', 'electronics')->first();
        $smartphones = Category::where('slug', 'smartphones')->first();
        $laptops = Category::where('slug', 'laptops')->first();
        $clothing = Category::where('slug', 'clothing-fashion')->first();
        $mensClothing = Category::where('slug', 'mens-clothing')->first();
        $womensClothing = Category::where('slug', 'womens-clothing')->first();
        $food = Category::where('slug', 'food-beverages')->first();
        $freshProduce = Category::where('slug', 'fresh-produce')->first();
        $home = Category::where('slug', 'home-garden')->first();
        $furniture = Category::where('slug', 'furniture')->first();

        // Products for Producer 1 (Faty El Ouardi)
        $products1 = [
            [
                'name' => 'iPhone 14 Pro Max',
                'description' => 'Latest iPhone with 256GB storage, excellent condition. Includes original charger and box.',
                'price' => 1299.99,
                'stock' => 3,
                'category_id' => $smartphones->id,
            ],
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'description' => 'Premium Android smartphone with S Pen, 512GB storage, perfect for professionals.',
                'price' => 1199.99,
                'stock' => 2,
                'category_id' => $smartphones->id,
            ],
            [
                'name' => 'MacBook Pro 16-inch',
                'description' => 'M2 Pro chip, 32GB RAM, 1TB SSD. Perfect for developers and creative professionals.',
                'price' => 2499.99,
                'stock' => 1,
                'category_id' => $laptops->id,
            ],
            [
                'name' => 'Organic Argan Oil',
                'description' => 'Pure Moroccan argan oil, 100ml bottle. Perfect for hair and skin care.',
                'price' => 29.99,
                'stock' => 15,
                'category_id' => $freshProduce->id,
            ],
            [
                'name' => 'Traditional Moroccan Kaftan',
                'description' => 'Handmade kaftan with beautiful embroidery. Available in multiple sizes.',
                'price' => 89.99,
                'stock' => 8,
                'category_id' => $womensClothing->id,
            ],
            [
                'name' => 'Handwoven Berber Carpet',
                'description' => 'Authentic Berber carpet, 200x300cm, made by local artisans in the Atlas Mountains.',
                'price' => 299.99,
                'stock' => 4,
                'category_id' => $furniture->id,
            ],
        ];

        foreach ($products1 as $productData) {
            Product::create(array_merge($productData, ['user_id' => $producer1->id]));
        }

        // Products for Producer 2 (Ahmed Alami)
        $products2 = [
            [
                'name' => 'Dell XPS 13 Laptop',
                'description' => 'Ultra-portable laptop with Intel i7, 16GB RAM, 512GB SSD. Great for business.',
                'price' => 1299.99,
                'stock' => 5,
                'category_id' => $laptops->id,
            ],
            [
                'name' => 'Premium Leather Jacket',
                'description' => 'Genuine leather jacket, handcrafted in Morocco. Available in black and brown.',
                'price' => 159.99,
                'stock' => 6,
                'category_id' => $mensClothing->id,
            ],
            [
                'name' => 'Moroccan Mint Tea Set',
                'description' => 'Traditional tea set with teapot and 6 glasses. Perfect for authentic mint tea experience.',
                'price' => 45.99,
                'stock' => 12,
                'category_id' => $home->id,
            ],
            [
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation. 30-hour battery life.',
                'price' => 199.99,
                'stock' => 8,
                'category_id' => $electronics->id,
            ],
            [
                'name' => 'Organic Olive Oil',
                'description' => 'Extra virgin olive oil from local olive groves. 500ml bottle.',
                'price' => 24.99,
                'stock' => 20,
                'category_id' => $freshProduce->id,
            ],
        ];

        foreach ($products2 as $productData) {
            Product::create(array_merge($productData, ['user_id' => $producer2->id]));
        }

        echo "Created " . count($products1) . " products for " . $producer1->name . "\n";
        echo "Created " . count($products2) . " products for " . $producer2->name . "\n";
        echo "Total products created: " . (count($products1) + count($products2)) . "\n";
    }
}
