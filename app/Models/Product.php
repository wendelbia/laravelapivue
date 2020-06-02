<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
        protected $fillable = ['id', 'category_id','name', 'description', 'image'];

	/*chamo os dados de $data
    public function getResults($data, $total) 
    {
	//se não existir dados filter e dados name e dados description
    	if (!isset($data['filter']) && !isset($data['name']) && !isset($data['description']))
	//então retorno
    		return $this->paginate($total);
    //vamos fazer o filtro mais avançado
    	//passo uma função de callback nesse função aplico um if condicional, esse função de callback não tem acesso a variáveis esternas por isso uso o use e pego a variável q qero usar no cado $data q é exatamente o array com os dados q qero usar aqui
    	//$results = $this->where(function ($query) use ($data) {
    	return $this->where(function ($query) use ($data) {
    	//se exitir o parâmetro filter, aqui estou tentando filtrar pelo parâmetro filter
    		if (isset($data['filter'])) {
    	//armazeno na var filter
    			$filter = $data['filter'];
    	//aqui uso o where q será o no termo de pesquisa e passo o que pesquisar q é o nome, (onde nome esse igual filtrado)
    			$query->where('name', $filter);
    	//aqui passo mais um termo de pesquisa q é o description (LIKE) igual a filter e % pesquisa tanto no começo como no fim do termo
    			$query->orWhere('description', 'LIKE', "%{$filter}%");
    		}

    		//posso fazer aqui para outros também
    		//se existir name
    		if(isset($data['name']))
    		{
    			//passo um parâmetro para ferificar se o nome é igual o q a pessoa passou como parâmetro
    			$query->where('name', $data['name']);
    		}
    		//nesse filter uso um like q contem a correspondencia do será pesquisado
    		if(isset($data['description']))
    		{
    			$description = $data['description'];
    			$query->where('description', 'LIKE', "%{$description}%");
    		}

    	})
    	//->toSql(); dd($results);
    	->paginate($total);//posso rodar um dd para saber qual query está sendo rodada
    }
*/
    public function getResults($data, $total)
    {
    	if (!isset($data['filter']) && !isset($data['name']) && !isset($data['description']))
    		return $this->paginate($total);
        
    	
    	
    	return $this->where(function ($query) use ($data) {
    		if (isset($data['filter'])) {
    			$filter = $data['filter'];
    			$query->where('name', $filter);
    			$query->orWhere('description', 'LIKE', "%{$filter}%");
            }
            
    		if (isset($data['name'])) 
    			$query->where('name', $data['name']);
            

    		if (isset($data['description'])) {
                $description = $data['description'];
    			$query->where('description', 'LIKE', "%{$description}%");
            }
    	})
        ->paginate($total);

    }

    //função para o relacionamento q vai retornar a categoria de produto
    public function category()
    {
        //método de muitos para um (belongsTo)
        return $this->belongsTo(Category::class);
        //crio uma rota em routes/api
    }
}
