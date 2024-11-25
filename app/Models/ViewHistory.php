<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewHistory extends Model
{
    use HasFactory;

    protected $table = 'view_history';

    protected $fillable = [
        'user_id',
        'movie_id',
        'watched_duration',
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

