<?php

namespace App\Exceptions;

use App\Http\Resources\ApiResponse;
use Illuminate\Support\Facades\Lang;
use Throwable;
use TypeError;

class TypeException implements IExceptionChains
{
    /**
     * Quando um tipo não é válido
     *
     * @param Throwable $exception
     * @param mixed $request
     *
     * @return [type]
     */
    public static function handler(Throwable $exception, $request)
    {

        if ($exception instanceof TypeError ) {
            return ApiResponse::return(
                [],
                Lang::get('default.type_error'),
                [true],
                422
            );
        }
        return FinalChaisException::handler($exception, $request);
    }
}

//TypeError
