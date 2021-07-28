<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $media = $this->mediaType()->first();

        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'image'=>$media?$media->path:'',
        ];
    }
}
