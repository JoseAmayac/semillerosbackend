<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
        if ($this->route('department')) {
            $id = $this->route('department')->id;
        }
        return [
            'name' => 'required|string|unique:departments,name,'.(int) $id,
            'description' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del departamento es obligatorio',
            'name.string' => 'El formato del nombre no es válido',
            'name.unique' => 'Ya existe un departamento con este nombre',
            'description.string' => 'El formato de la descripción no es válido'
        ];
    }
}
