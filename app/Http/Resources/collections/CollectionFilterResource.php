<?php

namespace App\Http\Resources\collections;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image = $this->medias()->first();
        
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'image'=>$image?$image->path:'' ,
        ];
    }
}
