<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Models\Product;

class Category extends Model
{
	protected $fillable = ['name', 'id'];
    //va fazer o filtro
    //parâmetrio é a palavra de pesquisa o name
    //deixo null para não ser obrigado a informar algum valor
    public function getResults($name = null)
    {
//se esse valor não for name
	if (!$name)
		//retorno todos os dados
		return $this->get();    	
//aqui em vez de usar $category uso $this q faz referência a model 
//usar return para não voltar vazio
//só passo o where tive item paa pesquisar
    		return $this->where('name', 'LIKE', "%{$name}%")
    				->get();
    }
//método qe vai retornar vários produtos
    public function products()
    {
//o método e um para muitos (hasMany) e passo nossa classe
//como ela está no newspace passo Product::class
        return $this->hasMany(Product::class);
    }
//e vou para o Product.php
}