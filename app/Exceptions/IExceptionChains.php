<?php

namespace App\Exceptions;

use Throwable;

interface IExceptionChains
{
    /**
     * @param Throwable $exception
     * @param mixed $request
     *
     * @return [type]
     */
    public static function handler(Throwable $exception, $request);
}
