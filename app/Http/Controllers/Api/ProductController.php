<?php
namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//inserindo a model
//use App\Models\Product;
use App\Models\Product;
//classe de validação
use App\Http\Requests\StoreUpdateProductFormRequest;
//vou no Request's e mudo para essa classe
//chamando o Storage para o update
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;


class ProductController extends Controller
{
    #=================================================================
    //criamos um construtor para não ter repetição de código
    //variável $totalPage para paginação em atribuo a quantidade q qero mostrar
    private $product, $totalPage = 5;
    //melhoria para manutenção da pasta
    private $path = 'products';

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    #==================================================================
    //retornar todos os produtos
    //public function index()
    //agora injeto o request para pesquisa do filtro
    public function index(Request $request)
    {
        //objeto q recebe os dados do produto através do objeto que recebe dados da model Product pelo método construtor
        //substituo o get por paginate
        //$products = $this->product->get();
        //essa paginação vai para model e aqui não fica poluido
        //$products = $this->product->paginate($this->totalPage);
        $products = $this->product->getResults($request->all(), $this->totalPage);
        return response()->json($products);
        

        //vou para routes/api
    }

    #===================================================================
    /*modificando o método storage para o upload de arquivos
    //mudo para a classe de validação
    //public function store(Request $request)
    public function store(StoreUpdateProductFormRequest $request)
    {
        //objeto product recebe o objeto da model com a função create que tem como parâmetro itens recebidos no request
        $product = $this->product->create($request->all());
        //retorna resposta json com parâmetro $product e status create
        return response()->json($product, 201);
    }
    */
    public function store(StoreUpdateProductFormRequest $request)
    {
        //crio a variável $date para receber o all()
        $data = $request->all();

        //vou identificar se querem fazer upload de arquivo q é opcional 
        //validação se existe aquivo para fazer upload, faço um if e verifico se existe um arquivo para fazer upload de imagem
        //se é um arquivo de imagem e é um arquivo de imagem válido então:
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            # dou um dd para verificar
            # dd('vai fazer upload');
            # não usaremos o nome do arquivo pois pode ter arquivos com o mesmo nome, então pego o próprio nome para fazer outro nome
            #o kebab_case tira os caracteres especiais
            $name = kebab_case($request->name);
            #pegaos a extensão
            $extension = $request->image->extension();
            #nome do nosso arquivo será concatenado com a extensão
            $nameFile = "{$name}.{$extension}";
            $data['image'] = $nameFile;
            //dd($nameFile);
            //store cria o renomeia o arquivo passo o path q fica no diretório products e o nome do arquivo
            $upload = $request->image->storeAs($this->path, $nameFile);
            #verifico se funcionou
            if (!$upload) {
                return response()->json(['error' => 'Fail_Upload'], 500);
            }

        }
        
        //objeto product recebe o objeto da model com a função create que tem como parâmetro itens recebidos no request
        $product = $this->product->create($data);
        //retorna resposta json com parâmetro $product e status create
        return response()->json($product, 201);
    }

    #==================================================================
  
    public function show($id)
    {
        //se não existir produto então 
        //if (!$product = $this->product->find($id))
        //buscando apenas um realcionamento o category
        if (!$product = $this->product->with('category')->find($id))
            return response()->json(['error' => 'Not Found'], 404);
        //dou um dd para ver o que tem em product
        //vejo em preview que no relacionamento não tem nada
        //dd($product);
        //para recuperar a categoria desse produto chamo category como atributo q é aquele método lá na model Product q faz o relacionamento entre category e product
        //dd($product->category);
        //posso também usar:
        //dd($product->category()->get());
        //posso também usar o first q trará apenas um registro
        //dd($product->category()->get()->first());
        //ou posso subtituir por category
        //dd($product->category);
        //buscando apenas um relacionamento
        //dd($product);

        //quando a pessoa quiser ver os dados do produto no client posso fazer assim:
        //posso fazer nesse formato 
        $category = $product->category;

        return response()->json([
            'product' => $product,
            'category'=> $category,
        ]);
        //ou deixar como está
        //  return response()->json($product);

    }

    /**===============================================================*/
    public function update(StoreUpdateProductFormRequest $request, $id)
    {
        # Objeto recebe da model q pega a função q buca pelo id 
        # $product = $this->product->find($id);

        # agora com o upload de imagem
        # senão existir product então retorne o erro não encontrado
        # posso colocar tudo dentro do if
        if (!$product = $this->product->find($id))
            return response()->json(['error' => 'Not Found'], 404);

        #------------------------parte incluida-------------------------
        
        # incluo para o upload, a variável recebe todos os dados da model
        $data = $request->all();

        # vou identificar se querem fazer upload que é opcional, faço um if para veridicar se existe arquivo de imagem, se tem arquivo (hasFile) de imagem e se é valido isValid()
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

        # aqui se existi aquivo de imagem vamos deletar o salvo
            if ($product->image) {
        # temos uma pasta chamada Storage que passo o caminho e chamo o use
        # se existe esse caminho...
                if (Storage::exists("{$this->path}/{$product->image}"))
                    Storage::delete("{$this->path}/{$product->image}");    
            }

        # posso dar um dd para verificar
        # dd('vai fazer upload');
        # não usaremos o nome original do arquivo então pego o name e pego a extensão do arquivo de imagem
        # o kebab_case tira os caracteres especiais
            $name = kebab_case($request->name);
        # pegamos a extensão
            $extension = $request->image->extension();
        # concatenamos o nome com a extensão
            $nameFile = "{$name}.{$extension}";
        # armazenamos  no index image
            $data['image'] = $nameFile;
        # store cria e renomeia o arquivo e passo o path q fica no diretório products e o nome do arquivo
            $upload = $request->image->storeAs($this->path, $nameFile);
        # verifico se funcionou
            if (!$upload)
                return response()->json(['error' => 'Fail_Upload'], 500);
            
        }

        #-------------------------------------------------------------------

        #$product->update($request->all()); modifico para:
        $product->update($data);

        return response()->json($product);
    }

    /**=================================================================*/
    public function destroy($id)
    {
        if (!$product = $this->product->find($id))
            return response()->json(['error' => 'Not Found'], 404);
        #------------------inserindo a parte do upload de imagem----------
        # aqui se existi aquivo de imagem vamos deletar o salvo
        if ($product->image) {
        # temos uma pasta chamada Storage que passo o caminho e chamo o use
        # se existe esse caminho...
            if (Storage::exists("{$this->path}/{$product->image}"))
                Storage::delete("{$this->path}/{$product->image}");    
        }

        $product->delete();

        return response()->json(['success' => true, 204]);
    }
}
