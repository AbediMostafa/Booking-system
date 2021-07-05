<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'title'
    ];

    public static function booted()
    {
        static::deleting(function ($genre) {

            $genre->rooms()->detach();

            if ($genre->medias->count()) {
                $genre->medias->each(function ($media) {
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
    //relation with rooms table
    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    
    public function medias()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
