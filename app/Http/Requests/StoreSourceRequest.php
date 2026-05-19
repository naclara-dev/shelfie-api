<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:sources,name',
            'media_id' => 'required|integer|exists:media,id',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Source already registered.',
            'media_id.exists' => 'The media ID does not exist.',
        ];
    }
}
