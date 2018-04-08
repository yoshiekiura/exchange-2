<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|min:6|unique:users',
            'password' => 'required|string|min:6|max:255|confirmed',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Имя должно быть больше 3 символов.',
            'name.max' => 'Имя должно быть меньше 255 символов.',
            'name.required' => 'Введите имя.',
            'password.confirmed' => 'Пароль не совпадает.',
            'password.required' => 'Введите пароль.',
            'password.max' => 'Пароль должен быть меньше 255 символов.',
            'password.min' => 'Пароль должен быть больше 6 символов.',
            'password_confirmation.same' => 'Пароль не совпадает.',
            'password_confirmation.required' => 'Введите пароль.',
            'email.required' => 'Введите почту.',
            'email.max' => 'Почта должна содержать меньше 255 символов.',
            'email.unique' => 'Почта уже занята.',
            'email.min' => 'Почта должна содержать больше 6 символов.',
        ];
    }
}
