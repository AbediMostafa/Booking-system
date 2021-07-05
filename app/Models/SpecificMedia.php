<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificMedia extends Model
{
    use HasFactory;
    protected $table='specific_medias';
    protected $guarded = [];

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }
}
