<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;

class MediaStoreRequest extends FormRequest
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
            'file'=>'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg',
            'media_of'=>['required', Rule::in(['city','collection','room','other','genre','learn'])],
        ];
       
       
    }
}
