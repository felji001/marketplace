<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class AddMoroccanProducts extends Command
{
    protected $signature = 'products:add-moroccan';
    protected $description = 'Add Moroccan Quilts, Jewelry, Henna, and Traditional Clothing products';

    public function handle()
    {
        // Find Mohammed user
        $mohammed = User::where('name', 'LIKE', '%mohammed%')->first();
        
        if (!$mohammed) {
            $this->error('Mohammed user not found');
            return;
        }

        // Find appropriate categories
        $homeCategory = Category::where('name', 'LIKE', '%home%')->first();
        $fashionCategory = Category::where('name', 'LIKE', '%fashion%')
                                 ->orWhere('name', 'LIKE', '%clothing%')
                                 ->orWhere('name', 'LIKE', '%apparel%')
                                 ->first();
        $beautyCategory = Category::where('name', 'LIKE', '%beauty%')
                                ->orWhere('name', 'LIKE', '%health%')
                                ->orWhere('name', 'LIKE', '%personal%')
                                ->first();

        // Use Home & Garden as fallback
        $defaultCategory = $homeCategory ?: Category::first();

        // Moroccan Quilts & Blankets
        $quiltsProducts = [
            [
                'name' => 'Traditional Berber Wool Blanket',
                'description' => 'Handwoven Berber blanket made from pure wool by Atlas Mountain artisans. Features traditional geometric patterns in natural colors. Perfect for cold nights and as decorative throw.',
                'price' => 189.99,
                'stock' => 8,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Patchwork Quilt',
                'description' => 'Beautiful patchwork quilt featuring traditional Moroccan fabrics and patterns. Each piece tells a story of Moroccan heritage. Handstitched with care and attention to detail.',
                'price' => 249.99,
                'stock' => 5,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Handira Wedding Blanket',
                'description' => 'Authentic Handira wedding blanket with silver sequins and traditional Berber symbols. Originally worn by brides, now perfect as wall art or luxury throw.',
                'price' => 399.99,
                'stock' => 3,
                'category_id' => $homeCategory ? $homeCategory->id : $defaultCategory->id,
            ],
        ];

        // Moroccan Traditional Jewelry
        $jewelryProducts = [
            [
                'name' => 'Silver Berber Necklace',
                'description' => 'Authentic Berber silver necklace with traditional geometric pendants. Handcrafted by skilled artisans using ancient techniques passed down through generations.',
                'price' => 159.99,
                'stock' => 12,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Silver Bracelet Set',
                'description' => 'Set of 3 traditional Moroccan silver bracelets with intricate engravings and semi-precious stones. Each bracelet represents different regions of Morocco.',
                'price' => 89.99,
                'stock' => 15,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Traditional Moroccan Earrings',
                'description' => 'Elegant silver earrings with traditional Moroccan motifs and turquoise stones. Lightweight and comfortable for daily wear while maintaining authentic style.',
                'price' => 65.99,
                'stock' => 20,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
        ];

        // Henna and Body Art
        $hennaProducts = [
            [
                'name' => 'Pure Moroccan Henna Powder',
                'description' => 'Premium quality henna powder sourced from the best henna plants in Morocco. Perfect for hair coloring and traditional body art. 100% natural and chemical-free.',
                'price' => 25.99,
                'stock' => 30,
                'category_id' => $beautyCategory ? $beautyCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Henna Application Kit',
                'description' => 'Complete henna kit including pure henna powder, applicator cones, essential oils, and traditional stencils. Everything needed for beautiful henna designs.',
                'price' => 45.99,
                'stock' => 18,
                'category_id' => $beautyCategory ? $beautyCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Traditional Henna Stencils Set',
                'description' => 'Collection of 20 traditional Moroccan henna stencils featuring geometric patterns, florals, and bridal designs. Reusable and easy to apply.',
                'price' => 19.99,
                'stock' => 25,
                'category_id' => $beautyCategory ? $beautyCategory->id : $defaultCategory->id,
            ],
        ];

        // Traditional Moroccan Clothing
        $clothingProducts = [
            [
                'name' => 'Traditional Moroccan Kaftan',
                'description' => 'Elegant traditional kaftan with intricate embroidery and beautiful patterns. Made from high-quality fabric, perfect for special occasions or comfortable daily wear.',
                'price' => 199.99,
                'stock' => 10,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Djellaba Robe',
                'description' => 'Authentic Moroccan djellaba with hood, made from soft wool blend. Traditional garment perfect for both men and women, available in various colors.',
                'price' => 149.99,
                'stock' => 12,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Berber Traditional Vest',
                'description' => 'Handwoven Berber vest with traditional patterns and colors. Made by Atlas Mountain artisans using ancient weaving techniques. Perfect over modern clothing.',
                'price' => 89.99,
                'stock' => 8,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
            [
                'name' => 'Moroccan Babouche Slippers',
                'description' => 'Traditional Moroccan leather slippers (babouche) handcrafted in Fes. Soft leather with beautiful embroidery, perfect for indoor wear or as unique gifts.',
                'price' => 55.99,
                'stock' => 25,
                'category_id' => $fashionCategory ? $fashionCategory->id : $defaultCategory->id,
            ],
        ];

        // Create all products
        $allProducts = array_merge($quiltsProducts, $jewelryProducts, $hennaProducts, $clothingProducts);
        
        foreach ($allProducts as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'user_id' => $mohammed->id,
                'category_id' => $productData['category_id'],
            ]);
            
            $this->info("Created: {$product->name}");
        }

        $this->info('Successfully added all Moroccan traditional products!');
        $this->info('Categories used:');
        if ($homeCategory) $this->line("- Home & Garden: {$homeCategory->name}");
        if ($fashionCategory) $this->line("- Fashion: {$fashionCategory->name}");
        if ($beautyCategory) $this->line("- Beauty: {$beautyCategory->name}");
    }
}
