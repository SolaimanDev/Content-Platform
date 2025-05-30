<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'name' => 'General',
                'slug' => 'general'
            ],
            [
                'name' => 'Technology',
                'slug' => 'technology'
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports'
            ],
            [
                'name' => 'Entertainment',
                'slug' => 'entertainment'
            ]
            ];

            foreach ($data as $key => $value) {
                Category::create($value);
            }

    }
}
