<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    protected $fillable = [
        'user_id',
        'movie_id',
        'rating',
    ];

    // Liên kết với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Liên kết với Movie
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
