<?php

//==========podemos simplificar tudo isso ===========================
/*
//tipo de requisição é a get que vai receber, recurso é categories
$this->get('categories', 'Api\CategoryController@index');
//rota para inserir é do tipo post
$this->post('categories', 'Api\CategoryController@store');
//rota para update, essa rota deve ser do tipo put
$this->put('categories/{id}', 'Api\CategoryController@update');
//delete
$this->delete('categories/{id}', 'Api\CategoryController@delete');
*/
//usamos o recurso categories q é a url q eu qero trabalhar e passo o nosso controller resource, logo depois posso passar uma array, mas a partir do laravel 5.6 o laravel trouxe o apiResource ele vai enternder a funções de cada método
//--------------------------------------------------------------------------
//antes de agrupar
/*
$this->apiResource('categories', 'Api\CategoryController');

$this->apiResource('products', 'Api\ProductController');
//$this->get('products', 'Api\ProductController@index');

//rota para retornar todos os produtos de uma categoria
//passo id dinamicamente categories vai a url depois o id que quero retornar da categoria e recursos q qero retornar dessa categoria q no caso é products é crio esse método product no CategoryController
$this->get('categories/{id}/products', 'Api\CategoryController@products');
*/

//grupo de rotas para o versionamento
//posso usar env('') e colocar lá no utilitário env a versão
//se eu tentar acessar na url dará erro, tenho q colocar depois de api/ o v1/
//crio a pasta v1 no api e modifico o namespace dos controllers acrecentando v1 a eles.
//posso acrescentar ao segundo parâmetro das rotas abaixo o v1 como:
//$this->apiResource('categories', 'Api\v1\CategoryController');
// e deixo a chamada gourp assim:
//$this->group(['prefix' => 'v1'], function () {
//ou acrecento o namespace e subtraio Api\v1 dos parâmetros
//aplico um filtro com middleware do jwt
//$this->group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
//agora fica assim:
$this->group([
	'prefix' => 'v1', 
	'namespace' => 'Api\v1',
	//filtro do Kernel jwt que agora precisa enviar o token o erro 401: Token not provided, mas se eu requisitar um token e na key: authorization com o value: Baerer <com o token> então deixa acessar a lista

	/*outro formato é em config/auth.php no 
	'guards' => [
				

			'api' => [
				o driver padrão é token eu mudo para
				'driver' => 'jwt',
			]
		]
	e mudo aqui o middleware de jwt.auth para auth:api
	*/
	//'middleware' => 'jwt.auth'
	//para conexão com axios deixo vazio no momento
	//'middleware' => 'auth:api'
	//modifico também em AuthApiController com método contrutor
	],
	 function () {
	
	

	$this->apiResource('categories', 'CategoryController');

	$this->apiResource('products', 'ProductController');

	//rota para retornar todos os produtos de uma categoria
	//passo id dinamicamente categories vai a url depois o id que quero retornar da categoria e recursos q qero retornar dessa categoria q no caso é products é crio esse método product no CategoryController
	$this->get('categories/{id}/products', 'CategoryController@products');

});
//jwt
//vamos deixá-lo fora do grupo de rotas pois não faz parte do versionamento, mas poderiamos deixá-lo no grupo agrupando as outras pois tem o Api\v1
//rota para autenticação, aponto para o método 
$this->post('auth', 'Auth\AuthApiController@authenticate');

//rota para a autenticação de usuário
$this->get('me', 'Auth\AuthApiController@getAuthenticatedUser');
//no postma: http://cursolaravelapi.test/api/me dará um erro pois não tenho o token
//em headers coloco na key: Authorization em value: Bearer em uma nova aba digito na url: email, password... como método get para obter o token

//rota para aumentar o prazo para login após expirar
$this->post('auth-refresh', 'Auth\AuthApiController@refreshToken'); 
//vamos ao controller api


