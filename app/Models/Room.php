<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    // use HasSoftDelete;
    protected $table = "rooms";
    protected $fillable = ['name', 'description', 'banner', 'image', 'published_at', 'price'];
    protected $casts = ['image' => 'array','banner'=>'array'];
    protected $deletedAt = 'deleted_at';
    //relation with comment table
    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
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
}

