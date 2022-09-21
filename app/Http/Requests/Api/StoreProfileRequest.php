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
            'name'          => 'required|string|between:2,100',
            'email'         => 'required|string|email|max:100|unique:users',
            'post_code'     => 'required|integer|digits:6',
            'address'       => 'required|string',
            'proficiency'   => 'required|string',
            'contract'      => 'required|string',
            'salary'        => 'required|integer|digits:9'
        ];
    }
}