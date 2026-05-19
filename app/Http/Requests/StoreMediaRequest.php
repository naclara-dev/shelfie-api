<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:media,name',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Media already registered.',
        ];
    }
}
