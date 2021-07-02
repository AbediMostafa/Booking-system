<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    // relation with room table

    public static function booted()
    {
        static::deleting(function ($city) {

            if ($city->medias->count()) {
                $city->medias->each(function ($media) {
                    $media->update([
                        'media_of' => 'other',
                        'place' => 'other',
                        'mediaable_id' => null,
                        'mediaable_type' => null,
                    ]);
                });
            }
        });
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
