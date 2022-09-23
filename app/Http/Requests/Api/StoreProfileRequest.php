<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class StoreProfileRequest extends BaseRequest
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
            'name'              => 'required|string',
            'email'             => 'required|string|email|max:100|unique:users',
            'post_code'         => 'nullable|integer|digits:6',
            'salary'            => 'nullable|integer|digits:9',
            'avatar'            => 'nullable|mimes:jpeg,jpg,png,jpeg,gif|max:10000',
            'date_of_birth'     => 'nullable|date_format:Y-m-d|before:today',
            'password'          => 'required|string|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/',
        ];
    }
}
