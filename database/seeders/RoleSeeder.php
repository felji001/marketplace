<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator with full access to the system'
            ],
            [
                'name' => 'producer',
                'description' => 'Producer who can create and manage products'
            ],
            [
                'name' => 'buyer',
                'description' => 'Buyer who can browse and purchase products'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
