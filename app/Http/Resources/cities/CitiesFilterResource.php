<?php

namespace App\Http\Resources\cities;

use Illuminate\Http\Resources\Json\JsonResource;

class CitiesFilterResource extends JsonResource
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
            'name'=>$this->name,
            'image'=>$image?$image->path:'' ,
        ];
    }
}
