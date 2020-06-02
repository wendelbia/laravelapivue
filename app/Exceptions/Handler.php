<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //para fazermos um retorno mais amigável de erro
        //na url do projeto coloquei uma rota errada propositavelmente
        //primeiro faço um dd() para saber a origem do erro
        //verifico de quem é essa instância Exception
        //dd($exception);
        //pego o erro gerado lá que no caso é: Symfony\Component\HttpKernel\Exception\NotFoundHttpException
        //e gero um erro personalizado para ele
        //----------------------------------------------------------------
        //exceção 
        //if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
            # faço um tratamento diferente, personalizo a mensagem
            # return response()->json(['error' => 'Not_found_URI'], 404);
            # agora tratando quando o erro for ajax
            # então eu só deixarei esse return se a requisição for do tipo ajax
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            # se o q eu estiver esperando é do tipo Json
            if ($request->expectsJson())
                return response()->json(['error' => 'Not_found_URI'], $exception->getStatusCode());
        }

        //para tratar erro de verbo
        // aqui mudo a classe
         if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            # se o q eu estiver esperando é do tipo Json
            # só vou tratar se for do tipo ajax
            if ($request->expectsJson())
                //method_not_alowed é a mensagem para o usuário
                return response()->json(['error' => 'Method_Not_Allowed'], $exception->getStatusCode());
        }
        //validações caso o token seja expirado ou valido
        //substituo o $e por $exception
        if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) 
        return response()->json(['token_expired'], $exception->getStatusCode());
        //não preciso desse else if
        if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) 
        return response()->json(['token_invalid'], $exception->getStatusCode());

        return parent::render($request, $exception);
    }
}
