<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public static function booted()
    {
        static::deleting(function ($genre) {

            $genre->rooms()->detach();
            $genre->medias()->detach();
        });
    }
    //relation with rooms table
    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    public function medias()
    {
        return $this->morphToMany(Media::class, 'mediaable');
    }

    public function mediaType($place = 'front')
    {
        return $this->morphToMany(Media::class, 'mediaable')->wherePivot('place', $place);
    }
}
