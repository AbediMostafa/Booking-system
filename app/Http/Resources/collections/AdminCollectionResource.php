<?php

namespace App\Http\Resources\collections;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminCollectionResource extends JsonResource
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
            'name'=>$this->title,
            'image'=>$media?$media->path:'',
        ];
    }
}
