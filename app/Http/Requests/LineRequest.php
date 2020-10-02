<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LineRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'string',
            'group_id' => 'required|exists:groups,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre de la linea de investigación es obligatorio',
            'name.string' => 'El formato del nombre no es correcto',
            'description.string' => 'El formato de la descripción no es correcto',
            'group_id.required' => 'El grupo de investigación es obligatorio',
            'group_id.exists' => 'El grupo de investigación seleccionado no existe'
        ];
    }
}
