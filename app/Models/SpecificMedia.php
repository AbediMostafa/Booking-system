<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificMedia extends Model
{
    use HasFactory;
    protected $table = 'specific_medias';
    protected $guarded = [];

    public static function booted()
    {
        static::deleting(function($specificMedia){
            $specificMedia->medias()->detach();
        });
    }

    public function medias()
    {
        return $this->morphToMany(Media::class, 'mediaable');
    }

    public function mediaType($place = 'front')
    {
        return $this->morphToMany(Media::class, 'mediaable')->wherePivot('place', $place);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
