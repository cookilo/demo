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
            'name'              => 'required|string|between:2,100',
            'email'             => 'required|string|email|max:100|unique:users',
            'post_code'         => 'integer|digits:6',
            'address'           => 'string',
            'proficiency'       => 'string',
            'contract'          => 'string',
            'salary'            => 'integer|digits:9',
            'avatar'            => 'mimes:jpeg,jpg,png,jpeg,gif|max:10000',
            'date_of_birth'     => 'date_format:Y-m-d',
        ];
    }
}
