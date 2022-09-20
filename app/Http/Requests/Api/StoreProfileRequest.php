<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'age'           => 'required|integer|min:1|max:3',
            'proficiency'   => 'required|string',
            'contract'      => 'required|string',
            'salary'        => 'required|integer|max:9'
        ];
    }
}
