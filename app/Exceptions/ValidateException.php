<?php

namespace App\Exceptions;

use App\Http\Resources\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Trata a exceção nas validacoes dos FormRequests
 */
class ValidateException implements IExceptionChains
{

    /**
     * @param Throwable $exception
     * @param mixed $request
     *
     * @return [type]
     */
    public static  function handler(Throwable $exception, $request)
    {
        if ($exception instanceof ValidationException) {
            $errors = [
                'list' => $exception->errors(),
                'sent_api' => $request->except('password'),
            ];
            return ApiResponse::return(
                [],
                Lang::get('default.except_validation'),
                $errors,
                $exception->status
            );
        }

        return ModelException::handler($exception, $request);
    }
}