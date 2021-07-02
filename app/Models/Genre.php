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
