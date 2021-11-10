<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MultimediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $type = $this->multimediaable_type === 'post' ?
            'learn' :
            (
            $this->multimediaable_type === 'news' ?
                'news' :
                'movie'
            );

        return [
            'id'=>$this->multimediaable->id,
            'title' => $this->multimediaable->title,
            'brief' => $this->multimediaable->brief,
            'type' => $type,
            'image' => $this->multimediaable->mediaType()->first()->path,
        ];
    }
}
