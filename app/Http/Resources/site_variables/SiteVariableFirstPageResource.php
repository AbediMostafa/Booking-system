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
            'carousel' => [
                'carouselItems' => [
                    [
                        'path' => $sv->itemMedia('first_page_header_title_1'),
                        'text' => $sv->item('first_page_header_title_1'),
                        'paragraph' => $sv->item('first_page_header_text_1'),
                    ],
                    [
                        'path' => $sv->itemMedia('first_page_header_title_2'),
                        'text' => $sv->item('first_page_header_title_2'),
                        'paragraph' => $sv->item('first_page_header_text_2'),
                    ],
                    [
                        'path' => $sv->itemMedia('first_page_header_title_3'),
                        'text' => $sv->item('first_page_header_title_3'),
                        'paragraph' => $sv->item('first_page_header_text_3'),
                    ],

                ],
                'buttonText' => $sv->item('first_page_header_button_text')
            ],

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
                'nav' => [
                    'special' => [
                        'route' => 'special-rooms/special',
                        'title' => $sv->item('special_rooms_nav_special')
                    ],
                    'new' => [
                        'route' => 'special-rooms/new',
                        'title' => $sv->item('special_rooms_nav_new')
                    ],
                    'discount' => [
                        'route' => 'special-rooms/discount',
                        'title' => $sv->item('special_rooms_nav_discount')
                    ]
                ]
            ],

            //first page learning
            'learning' => [
                'title' => $sv->item('first_page_learning_title'),
                'text' => $sv->item('first_page_learning_text'),
                'button' => $sv->item('first_page_learning_button_text'),
            ],

            'collection' => [
                'title' => $sv->item('first_page_collection_title'),
                'text' => $sv->item('first_page_collection_text'),
                'button' => $sv->item('first_page_collection_button_text'),
            ]
        ];
    }
}
