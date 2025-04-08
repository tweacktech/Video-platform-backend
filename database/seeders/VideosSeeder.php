<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\videos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\videos::factory(3)->create();


    $users = User::all();
    $categories = Category::all();

    $videos = [
        [
            'title' => 'Introduction to Laravel',
            'description' => 'Learn the basics of Laravel framework',
            'file_path' => 'videos/3wyhxFxbJTckhiMkhrp3oCceEqqflrcwTUS1Qk44.mp4',
            'thumbnail_path' => 'thumbnails/9ITll0uWTqi1LDDklgJOtL7JkAlq9hOY0ZaSi4O1.png',
            'status' => 'completed',
            'duration' => 600, // 10 minutes
        ],
        [
            'title' => 'Vue.js for Beginners',
            'description' => 'Get started with Vue.js 3 and the Composition API',
            'file_path' => 'videos/CkzOsNBgOGTy804mfj5Jm2DbBpW4pifvQKG3nbSp.mp4',
            'thumbnail_path' => 'thumbnails/9ITll0uWTqi1LDDklgJOtL7JkAlq9hOY0ZaSi4O1.png',
            'status' => 'completed',
            'duration' => 900, // 15 minutes
        ],
        [
            'title' => 'Building REST APIs',
            'description' => 'How to build RESTful APIs with Laravel',
            'file_path' => 'videos/3wyhxFxbJTckhiMkhrp3oCceEqqflrcwTUS1Qk44.mp4',
            'thumbnail_path' => 'thumbnails/9ITll0uWTqi1LDDklgJOtL7JkAlq9hOY0ZaSi4O1.png',
            'status' => 'completed',
            'duration' => 1200, // 20 minutes
        ],
        [
            'title' => 'CSS Animation Techniques',
            'description' => 'Advanced CSS animations for modern websites',
            'file_path' => 'videos/3wyhxFxbJTckhiMkhrp3oCceEqqflrcwTUS1Qk44.mp4',
            'thumbnail_path' => 'thumbnails/9ITll0uWTqi1LDDklgJOtL7JkAlq9hOY0ZaSi4O1.png',
            'status' => 'completed',
            'duration' => 750, // 12.5 minutes
        ],
        [
            'title' => 'TypeScript Deep Dive',
            'description' => 'Advanced TypeScript features and patterns',
            'file_path' => 'videos/CkzOsNBgOGTy804mfj5Jm2DbBpW4pifvQKG3nbSp.mp4',
            'thumbnail_path' => 'thumbnails/sample-typescript.jpg',
            'status' => 'completed',
            'duration' => 1800, // 30 minutes
        ],
    ];

    foreach ($videos as $video) {
        videos::create([
            'user_id' => $users->random()->id,
            'category_id' => $categories->random()->id,
            'title' => $video['title'],
            'description' => $video['description'],
            'file_path' => $video['file_path'],
            'thumbnail_path' => $video['thumbnail_path'],
            'status' => $video['status'],
            'duration' => $video['duration'],
        ]);
    }

    }
}
