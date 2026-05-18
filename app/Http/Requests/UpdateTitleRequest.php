<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTitleRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (!$this->has('genres')) {
            return;
        }

        $genres = $this->input('genres');

        if (is_string($genres) && str_contains($genres, ',')) {
            $genres = array_map('trim', explode(',', $genres));
            $genres = array_values(array_filter($genres, function ($genre) {
                return $genre !== '';
            }));
        } elseif (!is_array($genres)) {
            $genres = [$genres];
        }

        $this->merge([
            'genres' => $genres
        ]);
    }

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
            'name'    => 'sometimes|string',
            'type'     => 'sometimes|string|exists:types,id',
            'year'     => 'sometimes|string',
            'imdb_id'  => 'sometimes|string',
            'genres'   => 'sometimes|array',
            'genres.*' => 'exists:genres,id|distinct' 
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'imdb_id.unique' => 'A title with this imdb_id already exists.'
        ];
    }
}
