<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:150',
            'gov_number' => 'required',
            'color' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
        ];
    }
}
