<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $technology = Category::firstOrCreate(
            ['slug' => 'technology'],
            [
                'name' => 'Technology',
                'status' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'laravel'],
            [
                'parent_id' => $technology->id,
                'name' => 'Laravel',
                'status' => true,
            ]
        );

        Category::firstOrCreate(
            ['slug' => 'php'],
            [
                'parent_id' => $technology->id,
                'name' => 'PHP',
                'status' => true,
            ]
        );
    }
}