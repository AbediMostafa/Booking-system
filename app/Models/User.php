<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'phone', 'score'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'type'
    ];

    public function getTypeAttribute()
    {
        return $this->role ? $this->role->name : '';
    }

    public static function getFirstOrCreate($person)
    {
        return User::firstOrCreate(
            ['phone' => $person->phone],
            [
                'name' => $person->name,
                'role_id' => Role::where('name', 'user')->first()->id
            ]
        );
    }

    public function isModerator()
    {
        $role = $this->role->name;

        return $role === 'admin'
            || $role === 'manager'
            || $role === 'room_owner';
    }

    public function isRoomOwner()
    {
        return $this->role->name === 'room_owner';
    }

    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    public function isManager()
    {
        return $this->role->name === 'manager';
    }

    public function isSuperUser(): bool
    {
        return Auth::check() && ($this->isAdmin() || $this->isManager());
    }

    //relation with posts table
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //relation with news table
    public function news()
    {
        return $this->hasMany(News::class);
    }

    //relation with news table
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }

    //relation with comments table
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //relation with rates table
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function reservations(): object
    {
        return $this->belongsToMany(Reservation::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'user_room');
    }
}
