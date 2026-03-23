<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'     => 'Test User',
                'email'    => 'test@example.com',
                'password' => bcrypt('password123'),
                'is_admin' => false,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'email'    => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'is_admin' => true,
            ]
        );
    }
}
