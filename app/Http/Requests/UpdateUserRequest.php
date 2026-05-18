<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $targetUser = $this->route('user');
        $user = $this->user();
        # An user only has permission to update your own information.
        return $user && $targetUser && ($user->isAdmin() || $user->id === $targetUser->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $targetUser = $this->route('user');
        $isAdmin = $this->user() && $this->user()->isAdmin();
        $targetUserId = $targetUser ? $targetUser->id : null;

        return [
            'username' => [
                'sometimes',
                'string',
                Rule::unique('users', 'username')->ignore($targetUserId),
            ],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($targetUserId),
            ],
            'password' => 'sometimes|string',
            'role_id'  => $isAdmin
                ? 'sometimes|exists:roles,id'
                : 'prohibited',
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
            'role_id.prohibited' => 'Only admins can update user roles.',
            'email.unique' => 'This email is already in use.',
            'username.unique' => 'This username is already in use.',
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
            'message' => 'You can only update your own user unless you are an admin.'
        ], 403));
    }
}
