<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'body'=> $this->body,
            'image'=> $this->image,
            'up_rate'=> $this->up_rate,
            'down_rate'=> $this->down_rate,
            'status'=> $this->down_rate,
            'use_idr'=> $this->down_rate,
        ];
    }
}
