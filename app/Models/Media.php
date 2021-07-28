<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'store_name',
        'path',
        'type',
    ];

    protected $appends = [
        'storagePath',
        'media_of'
    ];

    public function getStoragePathAttribute()
    {
        return str_replace('storage', 'public', $this->path);
    }

    public function getMediaOfAttribute()
    {
        return array_unique($this->mediaables->pluck('mediaable_type')->toArray());
    }

    protected static function booted()
    {
        static::deleting(function ($media) {
            $media->mediaables()->delete();

            $path = str_replace('storage', 'public', $media->path);
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        });
    }

    public function cities()
    {
        return $this->morphedByMany(City::class, 'mediaable');
    }

    public function rooms()
    {
        return $this->morphedByMany(Room::class, 'mediaable');
    }

    public function collections()
    {
        return $this->morphedByMany(Collection::class, 'mediaable');
    }

    public function genres()
    {
        return $this->morphedByMany(Genre::class, 'mediaable');
    }

    public function mediaables()
    {
        return $this->hasMany(Mediaable::class);
    }
}
