<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Database\Factories\CategoryMovieFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Category::factory(50)->create();
        // \App\Models\Movie::factory(50)->create();
        // \App\Models\CategoryMovie::factory(50)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            CategorySeeder::class,
            MovieSeeder::class,
            CategoryMovieSeeder::class,
            EpisodeSeeder::class,
        ]);

    }
}
