<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPrice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function customQuery()
    {
        return self::with([

            'room' => function ($q) {
                $q->select('id', 'name');

            },
            'hour' => function ($q) {
                $q->select('id', 'start_time', 'end_time');

            },
            'day' => function ($q) {
                $q->select('id', 'name');
            },
        ])
            ->orderBy('room_id')
            ->orderBy('day_id')
            ->select('id', 'price', 'room_id', 'hour_id', 'day_id');

    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function hour()
    {
        return $this->belongsTo(Hour::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
