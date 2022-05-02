<?php

namespace App\Exceptions;

use App\Http\Resources\ApiResponse;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Support\Facades\Lang;
use Throwable;

class RelationException implements IExceptionChains
{
    /**
     * Quando um relacionamento não é encontrado retornamos 404
     *
     * @param Throwable $exception
     * @param mixed $request
     *
     * @return [type]
     */
    public static function handler(Throwable $exception, $request)
    {
        if ($exception instanceof RelationNotFoundException) {
            return ApiResponse::return(
                [],
                Lang::get('default.relationship_not_found'),
                [true],
                404
            );
        }
        return TypeException::handler($exception, $request);
    }
}
