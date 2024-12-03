<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = ['link_poster_internet', 'slug', 'link_video_internet', 'title', 'status', 'trailer_url', 'poster_url', 'video_url', 'type_film', 'rating', 'director', 'countries', 'duration', 'age_rating', 'release_year', 'description'];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_movie');
    }
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function viewHistories()
    {
        return $this->hasMany(ViewHistory::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
