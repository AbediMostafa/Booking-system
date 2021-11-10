<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booted()
    {
        static::deleting(function ($collection) {
            $collection->medias()->detach();
        });

        static::created(function ($collection) {
            $collection->collection_order = $collection->id * 100 + 350000;
            $collection->save();
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
