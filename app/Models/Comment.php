<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=['parent_id','content','episode_id','user_id'];
    // Liên kết với User
    // public function user()
    // {
    //     return $this->belongsTo(User::class,'user_id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with(['user', 'replies']); // Load replies phân cấp
    }

}
