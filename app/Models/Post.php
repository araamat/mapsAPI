<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = []; // Allow mass assignment for all attributes

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
