<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //mudo para true
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
            //preenchimento obrigatório
            'name'      => 'required|min:3|max:100',
            //email é único
            //'email'     => 'required|email|max:150|unique:users',
            //mudamos para o email não ser único para poder atualizar todos os dados
            'email'     => "required|email|max:150|unique:users,email,{$this->id},id",
            'password'  => 'required|min:6|max:15'
            //vamos para AuthApiController implementar
        ];
    }
}
