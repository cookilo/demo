<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class UpdateProfileRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'              => 'nullable|string',
            'post_code'         => 'nullable|integer',
            'salary'            => 'nullable|integer',
            'avatar'            => 'nullable|mimes:jpeg,jpg,png,jpeg,gif|max:10000',
            'date_of_birth'     => 'nullable|date_format:Y-m-d|before:today',
            'password'          => 'stringmin:6|regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/',
        ];
    }
}
