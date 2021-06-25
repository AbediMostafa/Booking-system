<?php

namespace App\Http\Resources\comments;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'id'=>$this->id,
            'body'=>$this->body,
            'user'=>$this->user->name,
            'up_rate'=>$this->up_rate,
            'down_rate'=>$this->down_rate,
            'crated_at'=>$this->crated_at,
        ];
    }
}
