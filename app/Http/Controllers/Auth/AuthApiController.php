<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//devo dar use
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthApiController extends Controller
{
    //
    public function __construct()
   	{
   		$this->middleware('auth:api', ['except' => ['authenticate']]);
    }

     public function authenticate(Request $request)
    {

    	//método construtor com as novas modificações dos filtros
    	//o que está sendo feito aqui no método construtor é que todos os métodos de controller eu qero q  passem pelo auth com guard api modificado lá no api.php exceto o nosso authenticate pq ele não precisa passar o token pq quando eu for autenticar ele nem tem token ainda
    	
        // pego o email e o password q a pessoa enviou
        $credentials = $request->only('email', 'password');

        try {
            // faço a autenticação no JWTAuth e armazano no $token
            // se deu certo vou lá para o return response()...
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // se der errado vem a menssagem de erro com status 500
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        //recuperar o usuário autenticado é simples armazeno no $user e mando como parâmetro no return
        //podemos também recuperar o usuário quando se envia o token, vou na doc. no github ir wiki em authentication e pego o método authenticateUser e aplico no User.php a interface e coloco os use
        //no postman rodo /api/auth tipo post vai dar: "error": "invalid_credentials" então em body coloco as credenciais
       $user = auth()->user();

        return response()->json(compact('token', 'user'));
        //vamos para o postman http://cursolaravelapi.test/api/auth e seguirá o erro depois passo pelo body terá um erro mas vamos consertar na model User.php

    }
/*
{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9jdXJzb2xhcmF2ZWxhcGkudGVzdFwvYXBpXC9hdXRoIiwiaWF0IjoxNTg5NDEyNzAzLCJleHAiOjE1ODk0MTYzMDMsIm5iZiI6MTU4OTQxMjcwMywianRpIjoiN29EdXJxcUE0QU5iVXduUSIsInN1YiI6MywicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.YD_YAKb1iba4VTMeVwO7uSvwpUO83q-jxR1X4atzOuk"}


mais uma alternativa é recuperar o usuáio partir do momento que recuperamos o token:
*/

    public function getAuthenticatedUser()
	{
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

		}

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
	//no postman uso o post coloco na url: api/auth-refresh em headers  no authorization coloco um novo token e send, se eu tentar enviar uma requisição do tipo get com api/me não irá pois está com o token antigo 

}





















