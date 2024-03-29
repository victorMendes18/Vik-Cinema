<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaFormRequest extends FormRequest
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
            'nome'=>'required',
            'quantPessoas'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'nome.required'=>"Campo Nome é obrigatório",
            'quantPessoas.required'=>"Campo Quantidade de pessoas é obrigatório",
        ];
    }
}
