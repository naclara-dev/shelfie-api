<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $rating = $this->route('rating');        
        # Check if the requesting user is the creator of the register
        return $this->user() && $rating && $this->user()->id === $rating->created_by;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating'  => 'sometimes|between:0,10',
            'comment' => 'sometimes|string|max:255'
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'You can only update ratings created by you.'
        ], 403));
    }
}
