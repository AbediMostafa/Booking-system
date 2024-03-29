<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['jalaliDate'];

    public function users(): object
    {
        return $this->belongsToMany(User::class);
    }

    public function mainUser()
    {
        return $this->belongsToMany(User::class)->wherePivot('user_type', 'main');
    }

    public function optionalUser()
    {
        return $this->belongsToMany(User::class)->wherePivot('user_type', 'optional');
    }

    public function room(): object
    {
        return $this->belongsTo(Room::class);
    }

    public function hour(): object
    {
        return $this->belongsTo(Hour::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
