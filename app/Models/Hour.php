<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function hourTypes():object
    {
        return $this->belongsToMany(HourType::class, 'hour_type_hours', 'hour_type_id', 'hour_id');
    }

    public function customPrice()
    {
        return $this->hasMany(CustomPrice::class);
    }
}
