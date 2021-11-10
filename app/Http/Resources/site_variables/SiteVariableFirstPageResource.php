<?php

namespace App\Http\Resources\site_variables;

use App\Classes\SiteVariableService;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteVariableFirstPageResource extends JsonResource
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
            'carousel' => $sv->carouselItems(),

            //entity counts
            'entityCounts' => [
                'city' => $sv->item('city_count_text'),
                'collection' => $sv->item('collection_count_text'),
                'room' => $sv->item('escape_room_count_text'),
            ],

            //special rooms
            'specialRooms' => [
                'title' => $sv->item('special_rooms_title'),
                'text' => $sv->item('special_rooms_text'),
                'button'=>$sv->item('special_rooms_button'),
                'nav' => [
                    'special' => [
                        'route' => 'special-rooms/special',
                        'title' => $sv->item('special_rooms_poster_special'),
                        'image'=>$sv->itemMedia('special_rooms_nav_special'),
                    ],
                    'new' => [
                        'route' => 'special-rooms/new',
                        'title' => $sv->item('special_rooms_poster_new'),
                        'image'=>$sv->itemMedia('special_rooms_nav_new'),
                    ],
                    'discount' => [
                        'route' => 'special-rooms/discount',
                        'title' => $sv->item('special_rooms_poster_discount'),
                        'image'=>$sv->itemMedia('special_rooms_nav_discount'),
                    ]
                ]
            ],

            //room search
            'search'=>[
                'title'=>$sv->item('first_page_search_title'),
                'text'=>$sv->item('first_page_search_text'),
                'button'=>$sv->item('first_page_search_button'),
            ],

            //first page learning
            'learning' => [
                'title' => $sv->item('first_page_learning_title'),
                'text' => $sv->item('first_page_learning_text'),
                'button' => $sv->item('first_page_learning_button_text'),
            ],

            //first page multimedia
            'multimedia' =>[
                'title' => $sv->item('first_page_multimedia_title'),
                'text' => $sv->item('first_page_multimedia_text'),
            ],

            //first page collection
            'collection' => [
                'title' => $sv->item('first_page_collection_title'),
                'text' => $sv->item('first_page_collection_text'),
                'button' => $sv->item('first_page_collection_button_text'),
            ]
        ];
    }
}
