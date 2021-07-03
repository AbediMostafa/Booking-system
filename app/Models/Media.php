<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
protected $fillable=[
'display_name',
 'store_name',   
'path',
'media_of',
];

    use HasFactory;
    public function mediaable()
    {
        return $this->morphTo();
    }
    public static function booted()
    {
        static::deleting(function($media){
            $storagePath = str_replace('storage', 'public', $media->path);
    
            if (Storage::has($storagePath)) {
                Storage::delete($storagePath);
            }
            
        });

    }
}
