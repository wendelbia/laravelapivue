<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //modifico de false para true
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
            //o nome deve ser preenchido
            //mínimo 3 caracteres
            //máximo 100
            //único
            //dessa maneira não permiti cadastrar um nome que já existe de outro cadastro
            //'name' => 'required|min:3|max:100|unique:categories',
            //para corrigir isso coloco name q é a coluna q quero verificar o id do item e a coluna q qro fazer a verificação do id
            'name' => 
            "required|min:3|max:100|unique:categories,name,{$this->id},id",

        ];
    }
}
