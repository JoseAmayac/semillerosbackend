<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicationRequest extends FormRequest
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
            'group_id' => 'required|exists:groups,id',
            'user_id' => 'required|exists:users,id',
            'link' => 'required|url',
            'references' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'group_id.required' => 'El grupo de investigación es obligatorio',
            'group_id.exists' => 'El grupo de investigación no existe',
            'user_id.required' => 'El autor de la publicación es obligatorio',
            'user_id.exists' => 'No existe un usuario con ese id',
            'link.required' => 'El link de la publicación es obligatorio',
            'link.url' => 'El formato del link no es correcto',
            'references.required' => 'Las referencias de la publicación son obligatorias'
        ];
    }
}
