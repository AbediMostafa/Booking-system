<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteVariables extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
