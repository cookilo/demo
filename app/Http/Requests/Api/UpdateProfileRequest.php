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
            'name' => 'string',
            'post_code' => 'integer|digits:6',
            'address' => 'string',
            'proficiency'   => 'string',
            'contract'      => 'string',
            'salary'        => 'integer|digits:9',
            'file'          => 'mimes:jpeg,jpg,png,jpeg,gif|max:10000',
        ];
    }
}
