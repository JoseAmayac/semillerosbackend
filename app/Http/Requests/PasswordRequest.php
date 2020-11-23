<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'La contraseña actual es obligatoria.',
            'new_password.required' => 'La nueva contraseña es obligatoria',
            'new_password.min' => 'La nueva contraseña debe contener al menos 8 caracteres',
            'new_password.confirmed' => 'La confirmación y la nueva contraseña no coinciden' 
        ];
    }
}
