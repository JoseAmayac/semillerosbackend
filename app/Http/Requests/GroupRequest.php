<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
        $id = null;
        if ($this->route('group')) {
            $id = $this->route('group')->id;
        }
        return [
            'name'=>'required|string|unique:groups,name,'.(int) $id,
            'description'=>'string',
            'department_id'=> 'required|exists:departments,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del grupo es obligatorio',
            'name.string' => 'El formato del nombre no es válido',
            'name.unique' => 'Ya existe un grupo con este nombre',
            'description.string' => 'El formato de la descripción no es válido',
            'department_id.required' => 'El departamento es obligatorio',
            'department_id.exists' => 'El departamento seleccionado no existe'
        ];

    }
}
