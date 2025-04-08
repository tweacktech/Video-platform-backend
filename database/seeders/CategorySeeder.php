<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Category::factory(3)->create();

        // // Create a specific category
        // // \App\Models\Category::factory()->create([
        // //     'name' => 'Specific Category',
        // //     'description' => 'This is a specific category.',
        // // ]);


        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Tech tutorials and gadget reviews'],
            ['name' => 'Education', 'slug' => 'education', 'description' => 'Educational content'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'description' => 'Fun and entertaining videos'],
            ['name' => 'Gaming', 'slug' => 'gaming', 'description' => 'Gaming walkthroughs and reviews'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
