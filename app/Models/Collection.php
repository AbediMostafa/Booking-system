<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    //relation with rooms table
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
