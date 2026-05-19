<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $media = $this->route('media');

        return [
            'name' => [
                'sometimes',
                'string',
                Rule::unique('media', 'name')->ignore($media ? $media->id : null),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Media already registered.',
        ];
    }
}
