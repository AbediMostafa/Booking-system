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

    public function getCalculateRateAttribute()
    {
        $sum=$this->scariness+$this->room_decoration+$this->hobbiness+$this->creativeness+$this->Mysteriness;
        return $sum/5;
    }
}
