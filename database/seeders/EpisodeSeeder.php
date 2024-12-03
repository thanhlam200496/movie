<?php

namespace Database\Seeders;

use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EpisodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::all();
        foreach ($movies as $movie) {
            if ($movie->type_film=="Movie") {
                Episode::create([
                    'movie_id' => $movie->id,
                    'title' => "Special Episode",
                    'episode_number' => 1,
                    'video_url' => null,
                    'link_video_internet'=>'https://vip.opstream16.com/20230114/29210_45f6d896/index.m3u8'
                ]);
            }else {
                for ($i = 1; $i <= 10; $i++) { // Tạo 10 tập cho mỗi phim
                Episode::create([
                    'movie_id' => $movie->id,
                    'title' => "Episode $i of {$movie->title}",
                    'episode_number' => $i,
                    'video_url' => null,
                    'link_video_internet'=>'https://vip.opstream16.com/20230114/29210_45f6d896/index.m3u8'
                ]);
            }
            }
            
        }
    }
}
