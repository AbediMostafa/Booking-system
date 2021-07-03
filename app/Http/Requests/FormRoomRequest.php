<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRoomRequest extends FormRequest
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
        return[
            'room.address'=>'required',
            'room.city_id'=>'required|integer',
            'room.collection_id'=>'required|integer',
            'room.description'=>'required',
            'room.district'=>'required',
            'room.game_time'=>'required',
            'room.hardness'=>'required',
            'room.is_new'=>'required|boolean',
            'room.is_special'=>'required|boolean',
            'room.max_person'=>'required|integer',
            'room.min_person'=>'required|integer',
            'room.mobile'=>'required|numeric|max:11',
            'room.name'=>'required',
            'room.phone'=>'required|numeric',
            'room.price'=>'required',

            'hasDiscount'=>'boolean',
            'discount.amount'=>'exclude_if:hasDiscount,false|required',
            'discount.started_at'=>'exclude_if:hasDiscount,false|required|date_format:Y/m/d',
            'discount.ended_at'=>'exclude_if:hasDiscount,false|required|date_format:Y/m/d',

            'medias.banner.background'=>'',
            'medias.banner.id'=>'integer',
            'medias.banner.place'=>'',
            'medias.banner.type'=>'',

            'medias.front.background'=>'',
            'medias.front.id'=>'integer',
            'medias.front.place'=>'',
            'medias.front.type'=>'',

            'medias.video.background'=>'',
            'medias.video.id'=>'integer',
            'medias.video.place'=>'',
            'medias.video.type'=>'',
        ];
       
    }
}
