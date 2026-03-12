<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'title'    => 'required|string',
            'type'     => 'required|string|in:movie,series',
            'year'     => 'sometimes|string',
            'imdb_id'  => 'required|string',
            'genres'   => 'sometimes|array',
            'genres.*' => 'exists:genres,id|distinct'  
        ];
    }
}
