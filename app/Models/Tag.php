<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($tag) {
            $tag->rooms()->detach();
            $tag->posts()->detach();
            $tag->news()->detach();
            $tag->movies()->detach();
        });
    }

    public function rooms()
    {
        return $this->morphedByMany(Room::class, 'taggable');
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function news()
    {
        return $this->morphedByMany(News::class, 'taggable');
    }

    public function movies()
    {
        return $this->morphedByMany(Movie::class, 'taggable');
    }

}
