<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory;

    protected $table = "rooms";
    protected $appends = ['rate_average', 'rate_percent'];
    protected $casts = [
        'image' => 'array',
        'banner' => 'array'
    ];
    protected $deletedAt = 'deleted_at';
    protected $guarded = [];

    public static function booted()
    {
        static::deleting(function ($room) {
            $room->genres()->detach();
            $room->medias()->detach();
            $room->extraHolidays()->delete();
            $room->reservations()->delete();
            $room->specificMedia()->delete();

            if ($room->comments) {
                $room->comments->each(function ($comment) {
                    $comment->delete();
                });
            }
        });

        static::created(function($room){
            $room->room_order = $room->id*100 + 350000;
            $room->save();
        });
    }

    public function getRateAverageAttribute()
    {
        return $this->rates->avg('calculate_rate') ? $this->rates->avg('calculate_rate') : 0;
    }

    public function getRatePercentAttribute()
    {
        return $this->rate_average * 100 / 5;
    }
    //relation with comment table
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    //relation with genres table
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    // relation with discount table-> one to one
    public function discount()
    {
        return $this->hasOne(Discount::class);
    }
    //relation with cities table
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    //relation with collections table
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
    //relation with rates table
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function medias()
    {
        return $this->morphToMany(Media::class, 'mediaable');
    }

    public function mediaType($place = 'front')
    {
        return $this->morphToMany(Media::class, 'mediaable')->wherePivot('place', $place);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function specificMedia()
    {
        return $this->hasOne(SpecificMedia::class);
    }

    public function reservations():object
    {
        return $this->hasMany(Reservation::class);
    }

    public function closedHours():object
    {
        return $this->hasMany(ClosedHour::class);
    }

    public function hourType():object
    {
        return $this->belongsTo(HourType::class);
    }

    public function holidayType():object
    {
        return $this->belongsTo(HolidayType::class);
    }

    public function extraHolidays()
    {
        return $this->hasMany(ExtraHoliday::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_room');
    }

    public function customPrice()
    {
        return $this->hasMany(CustomPrice::class);
    }
}
