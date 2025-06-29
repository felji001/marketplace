<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class UpdateAhmedProducts extends Command
{
    protected $signature = 'products:update-ahmed';
    protected $description = 'Delete all Ahmed Alami products and add Carpet, Olive Oil, Leather Bags, and Tea products';

    public function handle()
    {
        // Find Ahmed Alami user
        $ahmed = User::where('name', 'LIKE', '%ahmed%')
                    ->orWhere('email', 'ahmed.producer@gmail.com')
                    ->first();

        if (!$ahmed) {
            $this->error('Ahmed Alami user not found. Let me show all users:');
            $users = User::all();
            foreach ($users as $user) {
                $this->line("ID: {$user->id}, Name: {$user->name}, Email: {$user->email}");
            }
            return;
        }

        $this->info("Found Ahmed: {$ahmed->name} (ID: {$ahmed->id})");

        // Delete all Ahmed's products
        $products = Product::where('user_id', $ahmed->id)->get();
        $this->info("Found {$products->count()} products to delete");

        foreach ($products as $product) {
            $this->line("Deleting: {$product->name}");
            $product->delete();
        }

        // Find appropriate categories
        $homeCategory = Category::where('name', 'LIKE', '%home%')->first();
        $foodCategory = Category::where('name', 'LIKE', '%food%')
                               ->orWhere('name', 'LIKE', '%grocery%')
                               ->orWhere('name', 'LIKE', '%fresh%')
                               ->first();
        $fashionCategory = Category::where('name', 'LIKE', '%fashion%')
                                 ->orWhere('name', 'LIKE', '%clothing%')
                                 ->orWhere('name', 'LIKE', '%accessories%')
                                 ->first();
        
        // Use first available category as fallback
        $defaultCategory = $homeCategory ?: $foodCategory ?: $fashionCategory ?: Category::first();

        $this->info("Available categories:");
        if ($homeCategory) $this->line("- Home: {$homeCategory->name}");
        if ($foodCategory) $this->line("- Food: {$foodCategory->name}");
        if ($fashionCategory) $this->line("- Fashion: {$fashionCategory->name}");

        // 15. Carpet & Textile Products
        $carpetProducts = [
            [
                'name' => 'Authentic Berber Carpet - Large',
                'description' => 'Handwoven Berber carpet from the Atlas Mountains. Features traditional geometric patterns in natural wool. Size: 300x200cm. Each carpet tells a unique story of Berber heritage.',
                'price' => 899.99,
                'stock' => 3,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Kilim Rug',
                'description' => 'Beautiful flat-woven kilim rug with vibrant colors and traditional patterns. Perfect for modern homes seeking authentic Moroccan style. Size: 200x150cm.',
                'price' => 299.99,
                'stock' => 8,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Boucherouite Rag Rug',
                'description' => 'Colorful recycled fabric rug made by Berber women. Each piece is unique, featuring bright colors and abstract patterns. Eco-friendly and full of character.',
                'price' => 189.99,
                'stock' => 12,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Textile Wall Hanging',
                'description' => 'Decorative textile wall hanging with traditional Moroccan patterns. Handwoven with intricate details, perfect for adding authentic Moroccan flair to any room.',
                'price' => 129.99,
                'stock' => 15,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
        ];

        // 16. Olives & Olive Oil
        $oliveProducts = [
            [
                'name' => 'Premium Moroccan Extra Virgin Olive Oil',
                'description' => 'Cold-pressed extra virgin olive oil from ancient olive groves in the Atlas Mountains. Rich flavor and exceptional quality. 500ml glass bottle.',
                'price' => 35.99,
                'stock' => 25,
                'category_id' => $foodCategory ? $foodCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Green Olives - Picholine',
                'description' => 'Premium Picholine green olives from Morocco, cured in traditional brine. Perfect for appetizers and Mediterranean dishes. 500g jar.',
                'price' => 18.99,
                'stock' => 30,
                'category_id' => $foodCategory ? $foodCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Mixed Moroccan Olives Selection',
                'description' => 'Gourmet selection of green and black Moroccan olives, marinated with herbs and spices. Traditional flavors in a convenient 750g jar.',
                'price' => 24.99,
                'stock' => 20,
                'category_id' => $foodCategory ? $foodCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Argan-Infused Olive Oil',
                'description' => 'Unique blend of olive oil infused with precious argan oil. Combines the benefits of both oils for cooking and drizzling. 250ml bottle.',
                'price' => 45.99,
                'stock' => 15,
                'category_id' => $foodCategory ? $foodCategory->id : $defaultCategory->id,
            ],
        ];

        // 17. Moroccan Leather Bags & Accessories
        $leatherProducts = [
            [
                'name' => 'Traditional Moroccan Leather Handbag',
                'description' => 'Handcrafted leather handbag from Fes artisans. Features traditional tooling and brass hardware. Perfect blend of style and functionality.',
                'price' => 159.99,
                'stock' => 12,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Leather Crossbody Bag',
                'description' => 'Compact crossbody bag made from genuine Moroccan leather. Ideal for travel and daily use. Features adjustable strap and secure closure.',
                'price' => 89.99,
                'stock' => 18,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Leather Wallet with Moroccan Design',
                'description' => 'Elegant leather wallet with traditional Moroccan geometric patterns. Multiple card slots and bill compartments. Perfect gift item.',
                'price' => 45.99,
                'stock' => 25,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Leather Belt',
                'description' => 'Handcrafted leather belt with traditional Moroccan buckle design. Available in brown and black. Adjustable size and durable construction.',
                'price' => 65.99,
                'stock' => 20,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
        ];

        // 18. Moroccan Tea Infusers & Strainers
        $teaProducts = [
            [
                'name' => 'Traditional Moroccan Tea Strainer',
                'description' => 'Authentic silver-plated tea strainer used in traditional Moroccan tea service. Fine mesh for perfect tea preparation. Essential for mint tea lovers.',
                'price' => 29.99,
                'stock' => 30,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Tea Infuser Set',
                'description' => 'Complete tea infuser set including mesh infuser, drip tray, and traditional Moroccan patterns. Perfect for loose leaf teas and herbs.',
                'price' => 39.99,
                'stock' => 22,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Brass Tea Strainer with Handle',
                'description' => 'Beautiful brass tea strainer with ornate handle and traditional Moroccan engravings. Functional art piece for tea enthusiasts.',
                'price' => 55.99,
                'stock' => 15,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
        ];

        // Create all products
        $allProducts = array_merge($carpetProducts, $oliveProducts, $leatherProducts, $teaProducts);
        
        foreach ($allProducts as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'user_id' => $ahmed->id,
                'category_id' => $productData['category_id'],
            ]);
            
            $this->info("Created: {$product->name}");
        }

        $this->info('Successfully updated Ahmed Alami\'s products!');
        $this->info("Total products created: " . count($allProducts));
        $this->info('Product categories:');
        $this->line('- Carpet & Textile Products: 4 items');
        $this->line('- Olives & Olive Oil: 4 items');
        $this->line('- Moroccan Leather Bags & Accessories: 4 items');
        $this->line('- Moroccan Tea Infusers & Strainers: 3 items');
    }
}
