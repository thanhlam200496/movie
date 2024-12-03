<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryMovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'movie_id' => Movie::factory(),  // Tạo một Movie mẫu liên kết với CategoryMovie
            'category_id' => Category::factory(),  // Tạo một Category mẫu liên kết với CategoryMovie
        ];
    }
}
