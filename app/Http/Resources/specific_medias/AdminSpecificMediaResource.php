<?php

namespace App\Http\Resources\specific_medias;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminSpecificMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $firstPageVideo = $this->where('name', 'first_page_video')->first();
        $firstPageVideoMedia = $firstPageVideo->medias()->first();

        $firstPageFullImage = $this->where('name', 'first_page_full_image')->first();
        $firstPageFullImageMedia = $firstPageFullImage->medias()->first();

        $firstPageFullVideo = $this->where('name', 'first_page_full_video')->first();
        $firstPageFullVideoMedia = $firstPageFullVideo->medias()->first();

        foreach ($this->where('name', 'banner_slider')->all() as $specificMedia) {
            $smMedia = $specificMedia->medias()->first();
            $medias[] = [
                'id' => $smMedia ? $smMedia->id : '',
                'background' => $smMedia ? $smMedia->path : '',
                'sm_id' => $specificMedia->id,
            ];
        }

        return [

            'staticMedias' => [
                'first_page_video' => [
                    'id' => $firstPageVideoMedia ? $firstPageVideoMedia->id : '',
                    'background' => $firstPageVideoMedia ? $firstPageVideoMedia->path : '',
                    'sm_id'=>$firstPageVideo->id
                ],

                'first_page_full_image' => [
                    'id' => $firstPageFullImageMedia ? $firstPageFullImageMedia->id : '',
                    'background' => $firstPageFullImageMedia ? $firstPageFullImageMedia->path : '',
                    'sm_id'=>$firstPageFullImage->id
                ],

                'first_page_full_video' => [
                    'id' => $firstPageFullVideoMedia ? $firstPageFullVideoMedia->id : '',
                    'background' => $firstPageFullVideoMedia ? $firstPageFullVideoMedia->path : '',
                    'sm_id'=>$firstPageFullVideo->id
                ]
            ],

            'dynamicMedias' => $medias
        ];
    }
}
