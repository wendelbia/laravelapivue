<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //vamos mudar o status para true
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //ditando regras de validação

        //uso o segment que é uma função para pegar as partes da url:
        /*http://cursolaravelapi.test/api/products/53?name=wwwe&category_id=1&description=dãdãdã
        temos o nosso domínio: http://cursolaravelapi.test
        o 1º: /api
        o 2º: /products
        o 3º: /53
        queremos pegar o id: 53
        */
        //dd$this->segment(3);
        //vamos armazenar em uma variável 
        $id = $this->segment(3);

        return [
            //informo também a categoria que o produto está relacionado
            //coloco como preenchimento obrigatório e informo a tabela que petence e também a chave primária da tabela para q não dê erro 
            'category_id'   => 'required|exists:categories,id',
            //para modificar/atualizar apenas a descrição, ele não permite, 
            //'name'          => 'required|min:3|max:10|unique:products',
            //pois acusa que o nome já existe, para que haja essa modificação
            //mudados para aspas duplas, dizemos q ele é (unique) unico da tabela produtos onde a coluna é name e passo o valor que ele faça a exeção caso seja o mesmo eu pego o $this->id que é o mesmo id da requisição q estão enviando para cá e a coluna q qero varificar que é id
            'name'          => "required|min:3|max:20|unique:products,name,{$id},id",
            'description'   => 'max:1000',
           // 'image'         => 'image',
        ];
    }
    //classe criada adiciono no ProductController
}
