<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class UpdateAdminUserRole extends Command
{
    protected $signature = 'user:update-admin-role';
    protected $description = 'Update Fadwa El Jihani to have only admin role';

    public function handle()
    {
        // Find Fadwa El Jihani
        $fadwa = User::where('email', 'fadwaeljihani@gmail.com')->first();

        if (!$fadwa) {
            $this->error('Fadwa El Jihani user not found');
            return;
        }

        $this->info("Found user: {$fadwa->name} ({$fadwa->email})");

        // Show current roles
        $currentRoles = $fadwa->roles->pluck('name')->toArray();
        $this->info("Current roles: " . implode(', ', $currentRoles));

        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();
        
        if (!$adminRole) {
            $this->error('Admin role not found');
            return;
        }

        // Remove all roles and assign only admin role
        $fadwa->roles()->detach();
        $fadwa->roles()->attach($adminRole->id);

        // Verify the change
        $newRoles = $fadwa->fresh()->roles->pluck('name')->toArray();
        $this->info("New roles: " . implode(', ', $newRoles));

        $this->info('Successfully updated Fadwa El Jihani to have only admin role');
    }
}
