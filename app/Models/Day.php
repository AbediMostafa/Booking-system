<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    public function holidayTypes():object
    {
        return $this->belongsToMany(HolidayType::class, 'holiday_days', 'day_id', 'holiday_id');
    }

    public function customPrice()
    {
        return $this->hasMany(CustomPrice::class);
    }

    public function closedHours():object
    {
        return $this->hasMany(ClosedHour::class);
    }
}
