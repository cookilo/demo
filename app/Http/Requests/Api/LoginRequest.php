<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
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
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => '電話番号を入力してください。',
            'email.email' => '電話番号を入力してください。',
            'password.required' => 'パスワードが空白にするのができません。',
            'password.min' => 'パスワードには6文字以上が含まれている必要となります。',
        ];
    }
}
