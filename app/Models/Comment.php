<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booted()
    {
        static::deleting(function ($comment) {

            if ($comment->parent_id === null) {

                $rate = Rate::where([
                    ['user_id', $comment->user_id],
                    ['room_id', $comment->commentable_id]
                ])->first();

                if ($rate) {
                    $rate->delete();
                }
            }
        });
    }

    //polymorphic one to many
    public function commentable()
    {
        return $this->morphTo();
    }

    //relation with users table
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function agreements()
    {
        return $this->morphMany(Agreement::class, 'agreementable');
    }
}
