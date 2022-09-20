<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name'          => 'string',
            'post_code'     => 'integer|digits:6',
            'address'       => 'string',
            'age'           => 'integer|min:2|max:5',
            'proficiency'   => 'string',
            'contract'      => 'string',
            'salary'        => 'integer|max:9'
        ];
    }
}
