<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hours():object
    {
        return $this->belongsToMany(Hour::class, 'hour_type_hours', 'hour_type_id', 'hour_id');
    }

    public function rooms():object
    {
        return $this->hasMany(Room::class);
    }
}
