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
            'postData.reservedPersons.0.name'=>'نام نفر اول',
            'postData.reservedPersons.0.phone'=>'موبایل نفر اول',
            'postData.reservedPersons.1.phone'=>'موبایل نفر دوم',
            'postData.reservedPersons.2.phone'=>'موبایل نفر سوم',
            'postData.reservedPersons.3.phone'=>'موبایل نفر چهارم',
            'postData.reservedPersons.4.phone'=>'موبایل نفر پنجم',
            'postData.reservedPersons.5.phone'=>'موبایل نفر ششم',
            'postData.reservedPersons.6.phone'=>'موبایل نفر هفتم',
            'postData.reservedPersons.7.phone'=>'موبایل نفر هشتم',
            'postData.reservedPersons.8.phone'=>'موبایل نفر نهم',
            'postData.reservedPersons.9.phone'=>'موبایل نفر دهم',
            'postData.reservedPersons.10.phone'=>'موبایل نفر یازدهم',
            'postData.reservedPersons.11.phone'=>'موبایل نفر دوازدهم',
            'postData.reservedPersons.12.phone'=>'موبایل نفر سیزدهم',

            'postData.reservedPersons.1.name'=>'نام نفر دوم',
            'postData.reservedPersons.2.name'=>'نام نفر سوم',
            'postData.reservedPersons.3.name'=>'نام نفر چهارم',
            'postData.reservedPersons.4.name'=>'نام نفر پنجم',
            'postData.reservedPersons.5.name'=>'نام نفر ششم',
            'postData.reservedPersons.6.name'=>'نام نفر هفتم',
            'postData.reservedPersons.7.name'=>'نام نفر هشتم',
            'postData.reservedPersons.8.name'=>'نام نفر نهم',
            'postData.reservedPersons.9.name'=>'نام نفر دهم',
            'postData.reservedPersons.10.name'=>'نام نفر یازدهم',
            'postData.reservedPersons.11.name'=>'نام نفر دوازدهم',
            'postData.reservedPersons.12.name'=>'نام نفر سیزدهم',
        ];
    }
}
