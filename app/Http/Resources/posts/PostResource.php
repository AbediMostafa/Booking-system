<?php

namespace App\Http\Resources\posts;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => $this->id,
            'image' => $this->image,
            'date' => $this->date,
            'title' => $this->title,
            'brief' => $this->brief,
            'date'=>\Morilog\Jalali\Jalalian::forge($this->created_at)->format('%A %d %B %Y')
        ];
    }
}