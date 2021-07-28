<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    // relation with room table

    protected $guarded = [];

    public static function booted()
    {
        static::deleting(function ($city) {
            $city->medias()->detach();
        });
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
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
