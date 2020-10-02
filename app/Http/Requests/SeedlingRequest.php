<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeedlingRequest extends FormRequest
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
            'name'=>'required|string|unique:departments,name',
            'description'=>'string',
            'group_id'=>'required|exists:groups,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del semillero es obligatorio',
            'name.string' => 'El formato del nombre no es válido',
            'name.unique' => 'Ya existe un semillero con este nombre',
            'description.string' => 'El formato de la descripción no es válido',
            'group_id.required' => 'El grupo es obligatorio',
            'group_id.exists' => 'El grupo seleccionado no existe'
        ];
    }
}
