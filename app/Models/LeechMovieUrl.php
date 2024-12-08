<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeechMovieUrl extends Model
{
    use HasFactory;
    protected $table='leech_urls';
    protected $fillable=['url_detail','url_poster','slug','url_video_m3u8','name','url_list_movie'];
}
