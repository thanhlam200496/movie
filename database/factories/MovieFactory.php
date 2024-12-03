<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'release_year' => $this->faker->year,
            'age_rating' => $this->faker->randomElement([null, 3, 7, 13, 16, 18]),
            'duration' => $this->faker->numberBetween(60, 180),  // Thời gian phim (phút)
            'views' => $this->faker->numberBetween(0, 100000),
            'video_url' => $this->faker->url,
            'countries' => $this->faker->words(3, true),  // Giả lập nhiều quốc gia
            'director' => $this->faker->name,
            'rating' => $this->faker->randomFloat(1, 1, 9),  // Điểm đánh giá từ 1 đến 10
            'type_film' => $this->faker->randomElement(['TV Show', 'Movie']),
            'poster_url' => $this->faker->imageUrl,
            'trailer_url' => $this->faker->url,
            'status' => $this->faker->randomElement(['Hidden', 'Public', 'Not Released']),
        ];
    }
}
