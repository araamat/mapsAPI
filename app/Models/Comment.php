<?php

namespace App\Models;

use App\Observers\CommentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy(CommentObserver::class)]
class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Lisa virtuaalne atribuut JSON-i väljundisse
    protected $appends = ['created_at_for_humans'];

    /**
     * Seos kasutajaga (kes postitas kommentaari)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Seos postitusega
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Formateeritud kuupäev (näiteks "2 tundi tagasi")
     */
    public function createdAtForHumans(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans()
        );
    }
}
