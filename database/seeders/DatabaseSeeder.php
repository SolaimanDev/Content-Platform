<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@app.com',
            'role' => 'admin',
            'password' => bcrypt('12345678')
        ]);

        User::factory()->create([
            'name' => 'Test Writer',
            'email' => 'writer@app.com',
            'role' => 'writer',
            'password' => bcrypt('12345678')
        ]);

        $this->call([
        CategorySeeder::class,
    ]);
    }
}
