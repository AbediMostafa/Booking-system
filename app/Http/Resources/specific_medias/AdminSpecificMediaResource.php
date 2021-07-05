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

        $fpv = $this->where('name', 'first_page_video')->first()->medias()->first();
        $fpfi = $this->where('name', 'first_page_full_image')->first()->medias()->first();
        $fpfv = $this->where('name', 'first_page_full_video')->first()->medias()->first();

        foreach ($this->where('name', 'banner_slider')->all() as $specificMedia) {
            $medias[] = $specificMedia->medias()->select('id','path as background')->first();
        }

        return [

            'staticMedias' => [
                'first_page_video' => [
                    'id' => $fpv ? $fpv->id : '',
                    'background' => $fpv ? $fpv->path : '',
                ],

                'first_page_full_image' => [
                    'id' => $fpfi ? $fpfi->id : '',
                    'background' => $fpfi ? $fpfi->path : '',
                ],

                'first_page_full_video' => [
                    'id' => $fpfv ? $fpfv->id : '',
                    'background' => $fpfv ? $fpfv->path : '',
                ]

                ],

                'dynamicMedias' =>$medias
        ];
    }
}
