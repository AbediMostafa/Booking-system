<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booted()
    {
        static::deleting(function ($post) {
            $post->medias()->detach();
        });

        static::created(function ($movie) {
            if ($movie->movie_order) return;

            $movie->movie_order = $movie->id * 100 + 350000;
            $movie->save();
        });
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    //relation with users table
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medias()
    {
        return $this->morphToMany(Media::class, 'mediaable');
    }

    public function mediaType($place = 'front')
    {
        return $this->morphToMany(Media::class, 'mediaable')->wherePivot('place', $place);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function multimedia()
    {
        return $this->morphOne(Multimedia::class, 'multimediaable');
    }
}
