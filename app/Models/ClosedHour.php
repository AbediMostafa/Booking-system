<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosedHour extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function room(): object
    {
        return $this->belongsTo(Room::class);
    }

    public function hour(): object
    {
        return $this->belongsTo(Hour::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
