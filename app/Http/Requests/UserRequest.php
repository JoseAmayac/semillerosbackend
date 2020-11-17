<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'cellphone' => 'min:6|max:12',
            'role_id' => 'required|exists:roles,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico se encuentra en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'cellphone.min' => 'El número de celular debe contener al menos 6 caracteres',
            'cellphone.max' => 'El número de celular no puede contener más de 12 caracteres',
            'role_id.required' => 'El rol del usuario es obligatorio',
            'role_id.exists' => 'El rol seleccionado no existe'
        ];
    }
}
