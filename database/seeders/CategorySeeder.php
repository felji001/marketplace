<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create main categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'parent_id' => null,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing & Fashion',
            'slug' => 'clothing-fashion',
            'parent_id' => null,
        ]);

        $home = Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'parent_id' => null,
        ]);

        $food = Category::create([
            'name' => 'Food & Beverages',
            'slug' => 'food-beverages',
            'parent_id' => null,
        ]);

        $books = Category::create([
            'name' => 'Books & Media',
            'slug' => 'books-media',
            'parent_id' => null,
        ]);

        // Create subcategories for Electronics
        Category::create([
            'name' => 'Smartphones',
            'slug' => 'smartphones',
            'parent_id' => $electronics->id,
        ]);

        Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'parent_id' => $electronics->id,
        ]);

        Category::create([
            'name' => 'Headphones',
            'slug' => 'headphones',
            'parent_id' => $electronics->id,
        ]);

        // Create subcategories for Clothing
        Category::create([
            'name' => 'Men\'s Clothing',
            'slug' => 'mens-clothing',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'name' => 'Women\'s Clothing',
            'slug' => 'womens-clothing',
            'parent_id' => $clothing->id,
        ]);

        Category::create([
            'name' => 'Shoes',
            'slug' => 'shoes',
            'parent_id' => $clothing->id,
        ]);

        // Create subcategories for Home & Garden
        Category::create([
            'name' => 'Furniture',
            'slug' => 'furniture',
            'parent_id' => $home->id,
        ]);

        Category::create([
            'name' => 'Kitchen & Dining',
            'slug' => 'kitchen-dining',
            'parent_id' => $home->id,
        ]);

        Category::create([
            'name' => 'Garden Tools',
            'slug' => 'garden-tools',
            'parent_id' => $home->id,
        ]);

        // Create subcategories for Food & Beverages
        Category::create([
            'name' => 'Fresh Produce',
            'slug' => 'fresh-produce',
            'parent_id' => $food->id,
        ]);

        Category::create([
            'name' => 'Beverages',
            'slug' => 'beverages',
            'parent_id' => $food->id,
        ]);

        Category::create([
            'name' => 'Snacks',
            'slug' => 'snacks',
            'parent_id' => $food->id,
        ]);
    }
}
