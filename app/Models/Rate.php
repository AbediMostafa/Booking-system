<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    //relation with room table
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    //relation with user table
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
