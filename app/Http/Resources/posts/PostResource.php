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
        $image = $this->mediaType()->first();
        $video = $this->mediaType('video')->first();
        return [
            'id' => $this->id,
            'image' => $image? $image->path:'',
            'video'=>$video?$video->path:'',
            'date' => $this->date,
            'title' => $this->title,
            'brief' => $this->brief,
            'date'=>\Morilog\Jalali\Jalalian::forge($this->created_at)->format('%A %d %B %Y')
        ];
    }
}
