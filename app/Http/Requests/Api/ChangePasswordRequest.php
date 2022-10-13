<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
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
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'パスワードが空白にするのができません。',
            'password.min' => 'パスワードには6文字以上が含まれている必要となります。',
            'password.confirmed' => 'パスワード確認が一致しません',
        ];
    }
}
