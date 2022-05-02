<?php

namespace App\Exceptions;

use NunoMaduro\Collision\Adapters\Laravel\ExceptionHandler;
use Throwable;

class FinalChaisException extends ExceptionHandler implements IExceptionChains
{
    /**
     * Finaliza a corrente
     *
     * @param Throwable $exception
     * @param mixed $request
     *
     * @return [type]
     */
    public static function handler(Throwable $exception, $request)
    {
        return parent::render($request, $exception);
    }
}
