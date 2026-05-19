<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSourceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $source = $this->route('source');

        return [
            'name' => [
                'sometimes',
                'string',
                Rule::unique('sources', 'name')->ignore($source ? $source->id : null),
            ],
            'media_id' => 'sometimes|integer|exists:media,id',
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
