<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
//incluir a validação
use App\Http\Requests\StoreUpdateCategoryFormRequest;

class CategoryController extends Controller
{
	//se todo o método q for feito usuar o category o código vai ficar repetitivo en~tao será criado um construtor
	private $category, $totalPage = 10;

	public function __construct(Category $category)
	{
		$this->category = $category;
	}

    //crio função q retorna todos dados do banco
    //faço o request
    //public function index(Category $category, Request $request)
    //agora usando o __construtor substituo por $this->category
    public function index(Request $request)
    {
//pode ser ->get no lugar de all()
    	//$categories = $category->all();

//novo formato, agora com filtro usando o where, filtando pelo nome, usando o request que aponta para o name, vou trazer todas as categorias cuja pessoa pelo parâmetro
    	$categories = $this->category->getResults($request->name);
//podemos tirar o where para não ficar tão poluido, pois o princípio d responsabilidade fica rompido, posso levar o name para um repository ou módulo, então levo tudo isso para a model/Category
//   					$category
//    					->where('name', 'LIKE', "%{$request->name}%")
//    					->get();
//laravel já retorna com conversão em padrão json com status 200
    	//return $categories;
//ou posso também especificar
    	return response()->json($categories);
    }

    //public function store(Request $request)
//mudando para validação
	public function store(StoreUpdateCategoryFormRequest $request)	    
    {
    	//não preciso mais injetar o category, uso o __constructor
    	//passo o create e faço um array os os valores q quero incluir
    	//usando o all() ele já passa em formato de array
    	//o objeto category vai receber esses valores
    	$category = $this->category->create($request->all());
    	//retorna em formsto json, passo o array no promeiro parânetro, no segundo passo o status, para criação passo o status 201, que diz q deu certo mas o 201 diz que foi creação
    	return response()->json($category, 201);
    	//para q seja inserido preciso criar uma rota então vou no route/api
    }

    //editar catiguria
    //preciso receber o id do item q quero editar
    //public function update(Request $request, $id)
    public function update(StoreUpdateCategoryFormRequest $request, $id)
    {
    	//recupero a categoria q qro atualizar
    	//chamo o método find do eloquent, esse método permite recuperar o item pelo id
    	//$category = $this->category->find($id);
    	//==================================================
    	//fazendo melhorias
    	//se não category
    	if(!$category = $this->category->find($id))
    		//retorna resposta de erro: não encontrado
    		return response()->json(['erro' => 'Not found'], 404);
    	//===================================================

    	//passo um array pelo request
    	$category->update($request->all());
    	//não preciso passa o segundo parâmetro pois passa automáticamente q é o 200
    	return response()->json($category);
    	//crio a rota em route/api
    }

    public function destroy($id)
    {
    	//primeira recuperar o item que qero deletar
    	//se não category
    	if(!$category = $this->category->find($id))
    		//retorna resposta de erro: não encontrado
    		return response()->json(['erro' => 'Not found'], 404);
    	$category->delete();
    	//se quiser passar uma mensagem de sucesso coloque em json
    	return response()->json(['success' => true], 204);
    	//crio a rota 
    }

    //para visualizar os detalhes 
    public function show($id)
    {
    	//recupero pelo id é a lógica de buscar pelo id vista em update
    	//se não category
    	if(!$category = $this->category->find($id))
    		//retorna resposta de erro: não encontrado
    		return response()->json(['erro' => 'Not found'], 404);
    	//retorna os dados buscados no banco pela variável do tipo Category da model q é apresentada no formato json
    	//requisisão do tipo get
    	return response()->json($category);
    }
        //método q devolve todos os produtos vinculados a categoria q estou recebendo o id
    public function products($id)
    {
        //primeiro recupero a categoria pelo id
        //se não category
        //if(!$category = $this->category->find($id))
        //além do método find recuperar a categoria posso recuperar o relacionamento usando o with com esse método posso passar uma string com os realcionamentos ou um array com vários relacionamentos que no caso é products então agora vai trazer tanto a categoria quanto os relacionamentos
        //assim fica uma única consulta mais completa e só em uma linha q traz tanto a categoria quantos os produtos vinculados a ela
        //if(!$category = $this->category->with(['products'])->find($id))
        //agora para obter o total page
        if(!$category = $this->category->find($id))
            //retorna resposta de erro: não encontrado
            return response()->json(['erro' => 'Not found'], 404);
        
        //var recebe objeto do tipo Category q chama o métod da Model criado para fazer o relacionamento products() lá em Product.php
        //$products = $category->products()->get();
        //dd($category);

        //posso também simplificar assim não chamo o q e pega da própria propriedade products q o resultado vai ser o mesmo
        //$products = $category->products;
        //mas para usar paginação devo usar products()
        $products = $category->products()->paginate($this->totalPage);

        //response json q retornará os produtos como também categoria
        return response()->json([
            'category'  => $category,
            'products'  => $products,
        ]);
        #para trabalhar nesse formato requesito pelo método get url:api/categories/1/products
        # nesse formatos primeiro selecionei a categoria depois os produtos
        # poderia colocar tudo na mesma linha
    }
}
















