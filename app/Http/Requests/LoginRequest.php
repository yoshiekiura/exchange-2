<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|min:6|max:255|email',
            'password' => 'required|string|min:6|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.min' => 'Почта должна содержать больше 6 символов.',
            'email.max' => 'Почта должна содержать меньше 255 символов.',
            'email.required' => 'Введите почту.',
            'password.max' => 'Пароль должен содержать меньше 255 символов.',
            'password.min' => 'Пароль должен содержать больше 6 символов.',
            'password.required' => 'Введите пароль.',
            'email' => 'Почта должна быть вида name@mail.com',
        ];
    }
}
