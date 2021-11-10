<?php

namespace App\Http\Resources\rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $img = $this->medias()->where('place','front')->first();
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'district'=>$this->district,
            'image'=>$img?$img->path:'',
            'total' => $this->rate_percent,
        ];
    }
}
