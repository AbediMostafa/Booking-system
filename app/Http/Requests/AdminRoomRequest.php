<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRoomRequest extends FormRequest
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
            'room.name' => 'required',
            'room.game_time' => 'required',
            'room.price' => 'required',
            'room.hardness' => 'required',
            'room.min_person' => 'required',
            'room.max_person' => 'required',
            'room.phone' => 'required',
            'room.address' => 'required',
            'room.district' => 'required',
            'room.description' => 'required',
            'collection'=>'exists:collections,id',
            'city'=>'exists:cities,id',
            'discount.started_at'=>'exclude_if:hasDiscount,false|required',
            'discount.ended_at'=>'exclude_if:hasDiscount,false|required',
            'discount.amount'=>'exclude_if:hasDiscount,false|required',
            'genreIds'=>'required|array',
            'genreIds'=>'exists:genres,id',
        ];
    }
}
