<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'email' => 'required|min:6|max:255|email',
            'name' => 'required|min:3|max:255',
            'text' => 'required|min:6|max:2000',
        ];
    }

    public function messages()
    {
        return [
            'email.min' => 'Почта должна содержать больше 6 символов.',
            'email.max' => 'Почта должна содержать меньше 255 символов.',
            'email.required' => 'Введите почту.',
            'email' => 'Почта должна быть вида name@mail.com',
            'name.min' => 'Имя должно содержать больше 3 символов.',
            'name.max' => 'Имя должно содержать меньше 255 символов.',
            'name.required' => 'Введите имя.',
            'text.min' => 'Текст должен содержать больше 6 символов',
            'text.max' => 'Текст должен содержать меньше 2000 символов',
            'text.required' => 'Введите текст.',
        ];
    }
}
