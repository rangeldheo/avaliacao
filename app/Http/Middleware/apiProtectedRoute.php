<?php

namespace App\Http\Middleware;

use App\Http\Resources\ApiResponse;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = FacadesJWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return ApiResponse::return(
                    [],
                    'Não autorizado',
                    ['list' => [0 => ['Token inválido.']]],
                    401
                );
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {

                return ApiResponse::return(
                    [],
                    'Não autorizado',
                    ['list' => [0 => ['Token expirado.']]],
                    401
                );
            } else {

                return ApiResponse::return(
                    [],
                    'Não autorizado',
                    ['list' => [0 => ['Nenhum Token enviado.']]],
                    401
                );
            }
        }
        return $next($request);
    }
}
