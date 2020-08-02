<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ReportController extends Controller
{
	//especificamos qual o grupo de rota
	public function __construct() 
	{
		//o que posso fazer para não ficar usando o postman toda hora com teste reteste...? Eu comento o $this->middleware('auth:api'), vou no arquivo api.php e copio a rota, abro o web.php e registro a rota. e coloco no postman http://cursolaravelapi.test/reports-products usando o get
		//$this->middleware('auth:api');
	}

    //precisamos ir api.php para criar a rota
    public function products(Product $product, Request $request)
    {
    	//
    	$year = $request->year;

    	$products = $product->where('created_at', '>=', "{$year}-01-01")
    							->where('created_at', '<=', date('Y-m-t', strtotime("{$year}-12")))
    							->get()
    	//poderiamos usar o ->groupBy('date') mas as datas e horas nunca serão iguais portanto usaremos um callback and $query->created_at == $null;
    							->groupBy(function ($query) {
    								return $query->created_at->format('m'); 
    							});
    							//o retorno do product são os dados completos com todas as colunas, nós vamos tratá-la para isso 
    	$labels = [];
    	$datasets = [];
    	foreach ($products as $product) {
    		//retornou com sucesso então isso aqui já será o nosso label
    		//dd($product[0]->created_at->format('m'));
    		$labels[] = "Mês {$product[0]->created_at->format('m')}";
    		//return $labels;
    		$datasets[] = count($product);
    		//return $datasets;



    	}
    	//usando o response para retornar em json();
    	//return response()->json($products);
    	//agora uso os labels e os datasets para montar o gráfico
    	return response()->json([
    		'labels' 		=> $labels,
    		'datasets'		=> $datasets,
    	]);
    }
}