<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function days():object
    {
        return $this->belongsToMany(Day::class, 'holiday_days', 'holiday_id','day_id' );
    }

    public function rooms():object
    {
        return $this->hasMany(Room::class);
    }
}
