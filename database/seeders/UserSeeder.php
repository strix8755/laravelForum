<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // Create regular user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        // Only create additional users if we have less than 10 users total
        if (User::count() < 10) {
            $additionalUsersToCreate = 10 - User::count();
            User::factory($additionalUsersToCreate)->create();
        }
    }
}
