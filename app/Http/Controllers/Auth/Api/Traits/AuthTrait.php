<?php 


namespace App\Http\Controllers\Auth\Api\Traits;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


trait AuthTrait
{
	//public function authenticate(Request $request)
    //para que o método seja usado dentro de outro método tiro o param
    public function authenticate()
    {

    	//método construtor com as novas modificações dos filtros
    	//o que está sendo feito aqui no método construtor é que todos os métodos de controller eu qero q  passem pelo auth com guard api modificado lá no api.php exceto o nosso authenticate pq ele não precisa passar o token pq quando eu for autenticar ele nem tem token ainda
    	
        // pego o email e o password q a pessoa enviou
        //em vez de usar o valor $request pois não terá mais essa var usso o request(), functionar da mesma forma e não precisaremos usar a classe request
        //$credentials = $request->only('email', 'password');
        $credentials = request()->only('email', 'password');

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

	public function getUser() {
			try {
				//aqui pego o token e o usuário autenticado
				//se deu certo armazena a variável em $user senão retorna response not found
				if (! $user = JWTAuth::parseToken()->authenticate()) {
					//vou comentar parte q não são necessárias
					//return response()->json(['user_not_found'], 404);
					//retorno um erro
					return [
						'response' => 'user_not_found',
						'status'   => 404
					];
				}

			} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

				//return response()->json(['token_expired'], $e->getStatusCode());
				//retorno um erro
					return [
						'response' => 'token_expired',
						'status' =>  $e->getStatusCode()
					];
			} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

				//return response()->json([''], $e->getStatusCode());
				//retorno um erro
					return [
						'response' => 'token_invalid',
						'status' =>  $e->getStatusCode()
					];
			} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

				//return response()->json(['token_absent'], $e->getStatusCode());
				//retorno um erro
					return [
						'response' => 'token_absent',
						'status' =>  $e->getStatusCode()
					];
			}
			//sucesso
			return [
						//'response' => 'user',
				'response' => $user,
						'status' => 200
					];
		}

	}