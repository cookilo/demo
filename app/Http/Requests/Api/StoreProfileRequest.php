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
            'name'                  => 'required|string',
            'email'                 => 'required|string|email|unique:users',
            'post_code'             => 'nullable|integer',
            'salary'                => 'nullable|integer',
            'avatar'                => 'nullable|mimes:jpeg,jpg,png,jpeg,gif|max:10000',
            'date_of_birth'         => 'nullable|date_format:Y-m-d|before:today',
            'password'              => 'required|confirmed|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'パスワードが空白にするのができません。',
            'password.min' => 'パスワードには8文字以上が含まれている必要となります。',
            'password.confirmed' => 'パスワード確認が一致しません',
            'email.unique' => '指定のメールアドレスは既に使用されています。',
        ];
    }
}
