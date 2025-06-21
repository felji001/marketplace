<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get roles
        $adminRole = Role::where('name', 'admin')->first();
        $producerRole = Role::where('name', 'producer')->first();
        $buyerRole = Role::where('name', 'buyer')->first();

        // Create Admin User
        $admin = User::create([
            'name' => 'Fadwa El Jihani',
            'email' => 'fadwaeljihani@gmail.com',
            'password' => Hash::make('password123'),
            'whatsapp_number' => '+212 666-123456',
            'email_verified_at' => now(),
        ]);
        $admin->roles()->attach($adminRole);

        // Create Producer User
        $producer = User::create([
            'name' => 'Faty El Ouardi',
            'email' => 'fatyelouardi@gmail.com',
            'password' => Hash::make('password123'),
            'whatsapp_number' => '+212 766-635841',
            'email_verified_at' => now(),
        ]);
        $producer->roles()->attach($producerRole);

        // Create Buyer User
        $buyer = User::create([
            'name' => 'Yasser Benali',
            'email' => 'yasser@gmail.com',
            'password' => Hash::make('password123'),
            'whatsapp_number' => '+212 777-888999',
            'email_verified_at' => now(),
        ]);
        $buyer->roles()->attach($buyerRole);

        // Create additional sample users for testing
        $producer2 = User::create([
            'name' => 'Ahmed Alami',
            'email' => 'ahmed.producer@gmail.com',
            'password' => Hash::make('password123'),
            'whatsapp_number' => '+212 661-234567',
            'email_verified_at' => now(),
        ]);
        $producer2->roles()->attach($producerRole);

        $buyer2 = User::create([
            'name' => 'Salma Tazi',
            'email' => 'salma.buyer@gmail.com',
            'password' => Hash::make('password123'),
            'whatsapp_number' => '+212 678-901234',
            'email_verified_at' => now(),
        ]);
        $buyer2->roles()->attach($buyerRole);

        echo "Created users:\n";
        echo "- Admin: fadwaeljihani@gmail.com (password: password123)\n";
        echo "- Producer: fatyelouardi@gmail.com (password: password123)\n";
        echo "- Buyer: yasser@gmail.com (password: password123)\n";
        echo "- Additional Producer: ahmed.producer@gmail.com (password: password123)\n";
        echo "- Additional Buyer: salma.buyer@gmail.com (password: password123)\n";
    }
}
