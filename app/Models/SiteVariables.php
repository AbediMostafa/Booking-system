<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteVariables extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booted()
    {
        static::deleting(function ($siteVar) {
            $siteVar->medias()->detach();
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
}
