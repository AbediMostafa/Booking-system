<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutFormRequest extends FormRequest
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
    public static function rules()
    {
        return [
            'postData.day'=>['required','string'],
            'postData.hour'=>'required|exists:hours,id',
            'postData.roomId'=>'required|exists:rooms,id',
            'postData.peopleCount'=>'required',
            'postData.prePayed'=>'required',
            'postData.totalAmount'=>'required',
            'postData.reservedPersons'=>'array|required',
            'postData.reservedPersons.*.name'=>'required_with:reservedPersons.*.phone|nullable|string|max:255',
            'postData.reservedPersons.*.phone' => 'required_with:reservedPersons.*.name|nullable|regex:/(09)[0-9]{9}/|digits:11|numeric',
            'postData.reservedPersons.0.name'=>'required',
            'postData.reservedPersons.0.phone'=>'required',
        ];
    }

    public static function getAttributes()
    {
        return [
            'postData.reservedPersons.0.name'=>'porsons mobile',
            'postData.reservedPersons.0.phone'=>'porsons mobile',
            'postData.reservedPersons.1.phone'=>'porsons mobile',
            'postData.reservedPersons.2.phone'=>'porsons mobile',
            'postData.reservedPersons.3.phone'=>'porsons mobile',
            'postData.reservedPersons.4.phone'=>'porsons mobile',
            'postData.reservedPersons.5.phone'=>'porsons mobile',
            'postData.reservedPersons.6.phone'=>'porsons mobile',
            'postData.reservedPersons.7.phone'=>'porsons mobile',
            'postData.reservedPersons.8.phone'=>'porsons mobile',
            'postData.reservedPersons.9.phone'=>'porsons mobile',
            'postData.reservedPersons.10.phone'=>'porsons mobile',
            'postData.reservedPersons.11.phone'=>'porsons mobile',
            'postData.reservedPersons.12.phone'=>'porsons mobile',

            'postData.reservedPersons.1.name'=>'name',
            'postData.reservedPersons.2.name'=>'name',
            'postData.reservedPersons.3.name'=>'name',
            'postData.reservedPersons.4.name'=>'name',
            'postData.reservedPersons.5.name'=>'name',
            'postData.reservedPersons.6.name'=>'name',
            'postData.reservedPersons.7.name'=>'name',
            'postData.reservedPersons.8.name'=>'name',
            'postData.reservedPersons.9.name'=>'name',
            'postData.reservedPersons.10.name'=>'name',
            'postData.reservedPersons.11.name'=>'name',
            'postData.reservedPersons.12.name'=>'name',
        ];
    }
}
