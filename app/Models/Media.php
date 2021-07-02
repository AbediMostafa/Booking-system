<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'display_name',
        'store_name',
        'path',
        'media_of',
        'type',
        'place',
        'mediaable_id',
        'mediaable_type',
    ];

    protected $appends = [
        'storagePath'
    ];
    
    public function getStoragePathAttribute()
    {
        return str_replace('storage', 'public', $this->path);
    }

    protected static function booted()
    {
        static::deleting(function ($media) {
            $path = str_replace('storage', 'public', $media->path);
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        });
    }

    use HasFactory;
    public function mediaable()
    {
        return $this->morphTo();
    }

}
