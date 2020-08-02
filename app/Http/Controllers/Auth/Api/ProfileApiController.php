<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//chamo a page validação
use App\Http\Requests\StoreUpdateUserFormRequest;
use App\User;
use App\Http\Controllers\Auth\Api\Traits\AuthTrait;

class ProfileApiController extends Controller
{
	use AuthTrait;

	public function __construct()
	{
		//para acrescentar o register
   		//$this->middleware('auth:api', ['except' => ['authenticate']]);
   		//ele é uma exceção que não passa pelo auth api
   		$this->middleware('auth:api', ['except' => ['register']]);
    //no postman uso o post coloco na url: api/auth-refresh em headers  no authorization coloco um novo token e send, se eu tentar enviar uma requisição do tipo get com api/me não irá pois está com o token antigo 
	}

	//=========================================================================
	//crio o método register e usu o request para a requisição
	public function register(StoreUpdateUserFormRequest $request, User $user)
	{
		//para cadastrar o novo usuário lá em cima uso o user para chamar o app\user
		//poderia usar assim User::create mas vou injetar como parâmetro da função: User $user
		//poderia usar  e fazer uma operação através disso mas... apartir do momento que registra eu posso retornar os dados do usu ou posso retornar um 200 com ok ou redirecioná-lo
		//só assim não vai encriptar a senha do usu por isso
		//$user->create($request->all());
		//armazeno em um data
		//posso passar assim também
		//$data = $request->only(['name', 'email', 'password' e imagem também...])
		$data = $request->all();
		//aqui passo o data que recebe senha criptada
		$data['password'] = bcrypt($data['password']);
		$user->create($data);
		//agora em vêz de repetir toda a lógica do método authenticate() eu apenas o chamo
		//eu poderia passar como params o (Request $request) como lá está mas quando se chama um método dentro de outro método ele não consegui passar o request automaticamente, para isso vou no método e tiro a injeção de request
		return $this->authenticate();
		//** dará não autenticado pq no __construct()  e acrescento o register
	}


	//método para editar o login
	public function update(StoreUpdateUserFormRequest $request)
	{
		//poderia usar User::find($request->id); porem ela pode ser violada pelo javascript usando alguma técnica
		//vamos usar o token no getAuthenticatedUser vamos usar a mesma lógica não posso apenas chamá-lo pois tem um tipo de tratamento expecífico
		//o corpo desse método foi usado para construir o metodo getUser
		$response = $this->getUser();
		//para retornar os dados do usuário logado
		//faço o teste no postman usando o me depois de api/me em uma nova aba usando o get nisso passo o Authorization = Bearer com o token o X-Requested-With com o XMLHpptRequest q me retorno o status 200
		//dd($response);
		//O response me retorna o status verifico se ñ é 200 se for me retorna o user
		if ($response['status'] != 200) 
			
			return response()->json([$response['response']], $response['status']);
		$user = $response['response'];
		$user->update($request->all());
			return response()->json(compact('user'));
	}	
}
