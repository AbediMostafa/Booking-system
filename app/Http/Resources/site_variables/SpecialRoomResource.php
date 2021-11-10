<?php

namespace App\Http\Resources\site_variables;

use App\Classes\SiteVariableService;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecialRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sv = new SiteVariableService($this);

        return [
            'title' => $sv->item('special_rooms_title'),
            'text' => $sv->item('special_rooms_text'),
            'button'=>$sv->item('special_rooms_button'),
            'nav' => [
                'special' => [
                    'route' => '/special-rooms/special',
                    'title' => $sv->item('special_rooms_nav_special'),
                    'image'=>$sv->itemMedia('special_rooms_nav_special'),
                ],
                'new' => [
                    'route' => '/special-rooms/new',
                    'title' => $sv->item('special_rooms_nav_new'),
                    'image'=>$sv->itemMedia('special_rooms_nav_new'),
                ],
                'discount' => [
                    'route' => '/special-rooms/discount',
                    'title' => $sv->item('special_rooms_nav_discount'),
                    'image'=>$sv->itemMedia('special_rooms_nav_discount'),
                ]
            ]
        ];
    }
}
