<?php

namespace Database\Seeders;

use App\Models\CategoryMovie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryMovie::factory(50)->create();
    }
}
