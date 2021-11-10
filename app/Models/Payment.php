<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function initialConstruction($prePayed)
    {
        return Payment::create([
            'status' => 'processing',
            'amount' => $prePayed,
        ]);
    }

    public function makeReservation($data)
    {
        return $this->reservation()->create([
            'room_id' => $data->roomId,
            'hour_id' => $data->hour,
            'reservation_date' => $data->day,
            'people_count' => $data->peopleCount
        ]);
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
}
