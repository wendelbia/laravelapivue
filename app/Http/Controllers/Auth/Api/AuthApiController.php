<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//devo dar use
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

use App\Http\Controllers\Auth\Api\Traits\AuthTrait;


class AuthApiController extends Controller
{
	use AuthTrait;
    //
    public function __construct()
   	{
   		//$this->middleware('auth:api', ['except' => ['authenticate']]);
   		//ele é uma exceção que não passa pelo auth api
   		$this->middleware('auth:api', ['except' => ['authenticate']]);
    }

    
/*
{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9jdXJzb2xhcmF2ZWxhcGkudGVzdFwvYXBpXC9hdXRoIiwiaWF0IjoxNTg5NDEyNzAzLCJleHAiOjE1ODk0MTYzMDMsIm5iZiI6MTU4OTQxMjcwMywianRpIjoiN29EdXJxcUE0QU5iVXduUSIsInN1YiI6MywicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.YD_YAKb1iba4VTMeVwO7uSvwpUO83q-jxR1X4atzOuk"}


mais uma alternativa é recuperar o usuáio partir do momento que recuperamos o token:
*/
//agora a responsabilidade de trazer os dados do usu centralizamos nessa função agora reaproveito ele no update
    public function getAuthenticatedUser()
	{
		//o corpo desse método foi usado para construir o metodo getUser
		$response = $this->getUser();
		//para retornar os dados do usuário logado
		//faço o teste no postman usando o me depois de api/me em uma nova aba usando o get nisso passo o Authorization = Bearer com o token o X-Requested-With com o XMLHpptRequest q me retorno o status 200
		//dd($response);
		//O response me retorna o status verifico se ñ é 200 se for me retorna o user
		if ($response['status'] !=200) 
			/**/return response()->json([$response['response']], $response['status']);
		//crio uma var parra receber o próprio user
		$user = $response['response'];
		
		//para utilizar esse método 
		/*
		try {
			//aqui pego o token e o usuário autenticado
			//se deu certo armazena a variável em $user senão retorna response not found
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}

		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

			return response()->json(['token_expired'], $e->getStatusCode());

		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

			return response()->json(['token_invalid'], $e->getStatusCode());

		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

			return response()->json(['token_absent'], $e->getStatusCode());

		}*/

		// o token é válidoe e encotramos o usuário então: vamos fazer a rota em route/api
		return response()->json(compact('user'));
	}

	//função para o aumento do prazo de login
	public function refreshToken()
	{
		//se o toquem não for reconhecido então retorna 401
		if (!$token = JWTAuth::getToken())
			return response()->json(['error' => 'token_not_send'], 401);
		//uma vez que eu tenho o token farei o refresh dele
		try {
			//var recebe o método JWTAuth que chama o refresh(0)
			$token = JWTAuth::refresh();
			//tratamento para exeções
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['token_invalid'], $e->getStatusCode());
		}
		//retorno do token do usuário
		return response()->json(compact('token'));
	}

}





















