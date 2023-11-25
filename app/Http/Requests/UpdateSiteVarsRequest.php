<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteVarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_page_header_title_1' => 'required',
            'first_page_header_text_1' => 'required',
            'first_page_header_title_2' => 'required',
            'first_page_header_text_2' => 'required',
            'first_page_header_title_3' => 'required',
            'first_page_header_text_3' => 'required',
            'first_page_header_button_text' => 'required',
            'special_rooms_title' => 'required',
            'special_rooms_text' => 'required',
            'special_rooms_nav_special' => 'required',
            'special_rooms_nav_new' => 'required',
            'special_rooms_nav_discount' => 'required',
            'first_page_learning_title' => 'required',
            'first_page_learning_text' => 'required',
            'first_page_learning_button_text' => 'required',
            'first_page_collection_title' => 'required',
            'first_page_collection_text' => 'required',
            'first_page_collection_button_text' => 'required',
            'escape_room_count_text' => 'required',
            'collection_count_text' => 'required',
            'city_count_text' => 'required',
            'city_page_title' => 'required',
            'city_page_text' => 'required',
            'collection_page_title' => 'required',
            'collection_page_text' => 'required',
            'genre_page_title' => 'required',
            'genre_page_text' => 'required',
            'learning_page_title' => 'required',
            'learning_page_text' => 'required',
            'our_story_text' => 'required',
            'contact_us' => 'required',
            'rate_scariness' => 'required',
            'rate_room_decoration' => 'required',
            'rate_hobbiness' => 'required',
            'rate_creativeness' => 'required',
            'rate_mysteriness' => 'required',

        ];
    }

    public function attributes()
    {
    }
}
