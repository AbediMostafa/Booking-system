<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    //relation with comments table

    protected $guarded = [];

    public static function booted()
    {
        static::deleting(function($post){
            $post->medias()->detach();
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
