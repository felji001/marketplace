<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $producerRole = Role::firstOrCreate(['name' => 'producer']);
        $buyerRole = Role::firstOrCreate(['name' => 'buyer']);

        // Create test users
        $admin = User::firstOrCreate(
            ['email' => 'fadwaeljihani@gmail.com'],
            [
                'name' => 'Fadwa El Jihani',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'whatsapp_number' => '+212 666-123456'
            ]
        );
        $admin->roles()->syncWithoutDetaching([$adminRole->id, $producerRole->id, $buyerRole->id]);

        $producer = User::firstOrCreate(
            ['email' => 'fatyelouardi@gmail.com'],
            [
                'name' => 'Faty El Ouardi',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'whatsapp_number' => '+212 766-635841'
            ]
        );
        $producer->roles()->syncWithoutDetaching([$producerRole->id]);

        $buyer = User::firstOrCreate(
            ['email' => 'yasser@gmail.com'],
            [
                'name' => 'Yasser',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'whatsapp_number' => '+212 777-888999'
            ]
        );
        $buyer->roles()->syncWithoutDetaching([$buyerRole->id]);

        // Create additional test users
        $testUsers = [
            ['name' => 'Ahmed Hassan', 'email' => 'ahmed@example.com', 'role' => 'producer'],
            ['name' => 'Sara Benali', 'email' => 'sara@example.com', 'role' => 'producer'],
            ['name' => 'Omar Alami', 'email' => 'omar@example.com', 'role' => 'buyer'],
            ['name' => 'Leila Tazi', 'email' => 'leila@example.com', 'role' => 'buyer'],
        ];

        foreach ($testUsers as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'whatsapp_number' => '+212 ' . rand(600000000, 799999999)
                ]
            );

            $role = Role::where('name', $userData['role'])->first();
            $user->roles()->syncWithoutDetaching([$role->id]);
        }

        // Create categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics'],
            ['name' => 'Clothing', 'slug' => 'clothing'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden'],
            ['name' => 'Books', 'slug' => 'books'],
            ['name' => 'Sports', 'slug' => 'sports'],
            ['name' => 'Beauty', 'slug' => 'beauty'],
            ['name' => 'Automotive', 'slug' => 'automotive'],
            ['name' => 'Food & Beverages', 'slug' => 'food-beverages'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['name' => $categoryData['name']],
                ['slug' => $categoryData['slug']]
            );
        }

        // Create subcategories
        $electronicsCategory = Category::where('name', 'Electronics')->first();
        if ($electronicsCategory) {
            $subcategories = [
                ['name' => 'Smartphones', 'slug' => 'smartphones', 'parent_id' => $electronicsCategory->id],
                ['name' => 'Laptops', 'slug' => 'laptops', 'parent_id' => $electronicsCategory->id],
                ['name' => 'Tablets', 'slug' => 'tablets', 'parent_id' => $electronicsCategory->id],
            ];

            foreach ($subcategories as $subcategoryData) {
                Category::firstOrCreate(
                    ['name' => $subcategoryData['name'], 'parent_id' => $subcategoryData['parent_id']],
                    ['slug' => $subcategoryData['slug']]
                );
            }
        }

        // Create sample products
        $producers = User::whereHas('roles', function($q) {
            $q->where('name', 'producer');
        })->get();

        $categories = Category::all();

        $sampleProducts = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced camera system and A17 Pro chip. Perfect condition, barely used.',
                'price' => 999.99,
                'stock' => 5,
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'Powerful and lightweight laptop perfect for work and creativity. 13-inch display, 256GB storage.',
                'price' => 1199.99,
                'stock' => 3,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Premium Android smartphone with excellent camera and display quality.',
                'price' => 799.99,
                'stock' => 8,
            ],
            [
                'name' => 'Designer Handbag',
                'description' => 'Elegant leather handbag perfect for any occasion. High-quality materials and craftsmanship.',
                'price' => 299.99,
                'stock' => 2,
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium noise-canceling wireless headphones with excellent sound quality.',
                'price' => 199.99,
                'stock' => 12,
            ],
            [
                'name' => 'Gaming Chair',
                'description' => 'Ergonomic gaming chair with lumbar support and adjustable height.',
                'price' => 249.99,
                'stock' => 6,
            ],
            [
                'name' => 'Coffee Machine',
                'description' => 'Professional espresso machine for home use. Makes perfect coffee every time.',
                'price' => 399.99,
                'stock' => 4,
            ],
            [
                'name' => 'Fitness Tracker',
                'description' => 'Advanced fitness tracker with heart rate monitoring and GPS.',
                'price' => 149.99,
                'stock' => 15,
            ],
            [
                'name' => 'Organic Honey',
                'description' => 'Pure organic honey from local beekeepers. 500g jar.',
                'price' => 24.99,
                'stock' => 20,
            ],
            [
                'name' => 'Yoga Mat',
                'description' => 'High-quality non-slip yoga mat perfect for all types of exercise.',
                'price' => 39.99,
                'stock' => 10,
            ],
        ];

        foreach ($sampleProducts as $index => $productData) {
            $product = Product::firstOrCreate(
                ['name' => $productData['name']],
                [
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'user_id' => $producers->random()->id,
                    'category_id' => $categories->random()->id,
                ]
            );
        }

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Admin user: fadwaeljihani@gmail.com (password: password)');
        $this->command->info('Producer user: fatyelouardi@gmail.com (password: password)');
        $this->command->info('Buyer user: yasser@gmail.com (password: password)');
    }
}
