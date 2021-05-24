<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    //relation with rooms table
    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }
}
