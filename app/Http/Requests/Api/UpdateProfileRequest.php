<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

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
            'name' => 'string',
            'post_code' => 'integer|digits:6',
            'address' => 'string',
            'age' => 'integer|max:99',
            'proficiency'   => 'string',
            'contract'      => 'string',
            'salary'        => 'integer|max:9',
            'file'          => 'mimes:jpeg,jpg,png,jpeg,gif|max:10000',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'code' => 400,
            'data' => $validator->errors()
        ]));
    }
}
