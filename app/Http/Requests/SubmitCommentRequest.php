<?php

namespace App\Http\Requests;

use App\Models\SiteVariables;
use Illuminate\Foundation\Http\FormRequest;

class SubmitCommentRequest extends FormRequest
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
            'comment' => 'required',
            'scoresTitles.scariness.selectedKey' => 'required',
            'scoresTitles.room_decoration.selectedKey' => 'required',
            'scoresTitles.hobbiness.selectedKey' => 'required',
            'scoresTitles.creativeness.selectedKey' => 'required',
            'scoresTitles.mysteriness.selectedKey' => 'required',
            'selectedStatus' => 'required'
        ];
    }

    public function attributes()
    {
        $this->rateTitles = SiteVariables::where('variable', 'like', '%rate_%')->get();

        return [
            'scoresTitles.scariness.selectedKey' => $this->rateTitle('rate_scariness'),
            'scoresTitles.room_decoration.selectedKey' => $this->rateTitle('rate_room_decoration'),
            'scoresTitles.hobbiness.selectedKey' => $this->rateTitle('rate_hobbiness'),
            'scoresTitles.creativeness.selectedKey' => $this->rateTitle('rate_creativeness'),
            'scoresTitles.mysteriness.selectedKey' => $this->rateTitle('rate_mysteriness'),
        ];
    }

    public function rateTitle($title)
    {
        return $this->rateTitles->where('variable', $title)->first()->value;
    }
}
