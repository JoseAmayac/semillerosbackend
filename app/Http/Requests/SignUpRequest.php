<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'cellphone' => 'required|min:6|max:12',
            'program_id' => 'required|exists:programs,id'
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
            'cellphone.required' => 'El número de celular es obligatorio',
            'cellphone.min' => 'El número de celular debe contener al menos 6 caracteres',
            'cellphone.max' => 'El número de celular no puede contener más de 12 caracteres',
            'program_id.required' => 'El programa académico es obligatorio',
            'program_id.exists' => 'El programa académico seleccionado no existe'
        ];
    }
}
