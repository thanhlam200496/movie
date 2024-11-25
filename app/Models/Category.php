<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    public function movies()
{
    return $this->belongsToMany(Movie::class, 'category_movie');
}
protected $fillable=['name','description'];

}
