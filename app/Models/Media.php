<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
protected $fillable=[
'display_name',
 'store_name',   
'path',
'media_of',
];

    use HasFactory;
    public function mediaable()
    {
        return $this->morphTo();
    }
}
