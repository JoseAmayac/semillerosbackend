<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
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
            'name' => 'required|string|unique:programs,name',
            'description' => 'string',
            'department_id' => 'required|exists:departments,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del programa académico es obligatorio',
            'name.string' => 'El formato del nombre no es válido',
            'name.unique' => 'Ya existe un programa académico con este nombre',
            'description.string' => 'El formato de la descripción no es válido',
            'department_id.required' => 'El departamento es obligatorio',
            'department_id.exists' => 'El departamento seleccionado no existe'
        ];
    }
}
