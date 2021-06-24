<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    //polymorphic one to many
    public function commentable()
    {
        return $this->morphTo();
    }
    //relation with users table
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class,'parent_id');
    }
    public function childs()
    {
        return $this->hasMany(Comment::class,'parent_id');
    }
}
