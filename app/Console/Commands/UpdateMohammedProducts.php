<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class UpdateMohammedProducts extends Command
{
    protected $signature = 'products:update-mohammed';
    protected $description = 'Delete all Mohammed products and add Hand-Painted Ceramics products';

    public function handle()
    {
        // Find Mohammed user
        $mohammed = User::where('name', 'LIKE', '%mohammed%')
                       ->orWhere('name', 'LIKE', '%Mohammed%')
                       ->first();

        if (!$mohammed) {
            $this->error('Mohammed user not found. Let me show all users:');
            $users = User::all();
            foreach ($users as $user) {
                $this->line("ID: {$user->id}, Name: {$user->name}, Email: {$user->email}");
            }
            return;
        }

        $this->info("Found Mohammed: {$mohammed->name} (ID: {$mohammed->id})");

        // Delete all Mohammed's products
        $products = Product::where('user_id', $mohammed->id)->get();
        $this->info("Found {$products->count()} products to delete");

        foreach ($products as $product) {
            $this->line("Deleting: {$product->name}");
            $product->delete();
        }

        // Find appropriate categories for ceramics
        $ceramicsCategory = Category::where('name', 'LIKE', '%ceramic%')
                                  ->orWhere('name', 'LIKE', '%pottery%')
                                  ->orWhere('name', 'LIKE', '%home%')
                                  ->orWhere('name', 'LIKE', '%decor%')
                                  ->first();

        if (!$ceramicsCategory) {
            // Show available categories
            $this->error('No suitable category found. Available categories:');
            $categories = Category::all();
            foreach ($categories as $category) {
                $this->line("ID: {$category->id}, Name: {$category->name}");
            }
            return;
        }

        $this->info("Using category: {$ceramicsCategory->name}");

        // Create Hand-Painted Ceramics products
        $ceramicsProducts = [
            [
                'name' => 'Hand-Painted Ceramic Tagine',
                'description' => 'Traditional Moroccan tagine with beautiful hand-painted designs in vibrant blue and green patterns. Perfect for authentic Moroccan cooking and serving. Made by skilled artisans in Fes.',
                'price' => 89.99,
                'stock' => 12,
            ],
            [
                'name' => 'Moroccan Ceramic Dinner Plates Set',
                'description' => 'Set of 6 hand-painted ceramic dinner plates featuring intricate geometric patterns in traditional Moroccan colors - blue, green, yellow, and red. Each plate is unique and crafted in Safi.',
                'price' => 129.99,
                'stock' => 8,
            ],
            [
                'name' => 'Hand-Painted Ceramic Bowls Collection',
                'description' => 'Beautiful collection of 4 ceramic bowls with traditional Moroccan motifs. Perfect for serving couscous, salads, or as decorative pieces. Vibrant colors and authentic craftsmanship.',
                'price' => 65.99,
                'stock' => 15,
            ],
            [
                'name' => 'Moroccan Ceramic Coffee Mugs Set',
                'description' => 'Set of 4 hand-painted ceramic coffee mugs with traditional Berber patterns. Each mug features unique designs in blue, green, and yellow glazes. Perfect for morning coffee or tea.',
                'price' => 45.99,
                'stock' => 20,
            ],
            [
                'name' => 'Large Decorative Ceramic Vase',
                'description' => 'Stunning large ceramic vase with intricate hand-painted floral and geometric patterns. A masterpiece from Fes artisans, perfect as a centerpiece or decorative accent.',
                'price' => 159.99,
                'stock' => 6,
            ],
            [
                'name' => 'Moroccan Ceramic Serving Platter',
                'description' => 'Large hand-painted ceramic serving platter ideal for entertaining. Features traditional Moroccan patterns in rich blues and greens with gold accents. Perfect for special occasions.',
                'price' => 95.99,
                'stock' => 10,
            ],
            [
                'name' => 'Hand-Painted Ceramic Tea Set',
                'description' => 'Complete Moroccan tea set including teapot and 6 glasses with hand-painted ceramic holders. Traditional patterns in vibrant colors, perfect for authentic Moroccan tea service.',
                'price' => 179.99,
                'stock' => 5,
            ],
            [
                'name' => 'Ceramic Spice Jars Set',
                'description' => 'Set of 8 small ceramic jars with hand-painted lids, perfect for storing Moroccan spices. Each jar features different traditional patterns and comes with wooden spoons.',
                'price' => 75.99,
                'stock' => 12,
            ],
            [
                'name' => 'Moroccan Ceramic Fruit Bowl',
                'description' => 'Large decorative fruit bowl with stunning hand-painted designs. Features traditional Moroccan patterns in blue, green, and yellow. Functional art piece for any kitchen.',
                'price' => 55.99,
                'stock' => 18,
            ],
            [
                'name' => 'Hand-Painted Ceramic Tiles Set',
                'description' => 'Set of 12 decorative ceramic tiles with traditional Moroccan patterns. Perfect for creating a backsplash or decorative wall feature. Each tile is hand-painted and unique.',
                'price' => 199.99,
                'stock' => 7,
            ],
        ];

        foreach ($ceramicsProducts as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'user_id' => $mohammed->id,
                'category_id' => $ceramicsCategory->id,
            ]);
            
            $this->info("Created: {$product->name}");
        }

        $this->info('Successfully updated Mohammed\'s products with Hand-Painted Ceramics collection!');
    }
}
