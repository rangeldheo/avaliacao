<?php

namespace App\Exceptions;

use App\Http\Resources\ApiResponse;
use App\Utils\ModelsGlossary;
use App\Utils\SpecialChars;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Lang;
use Throwable;

class ModelException implements IExceptionChains
{
    /**
     *  Quando um modelo não é encontrado retornamos 404
     *
     * @param Throwable $exception
     * @param mixed $request
     *
     * @return [type]
     */
    public static function handler(Throwable $exception, $request)
    {
        if ($exception instanceof ModelNotFoundException) {
            return ApiResponse::return(
                [],
                ModelsGlossary::getName($exception->getModel()) . SpecialChars::SPACE . Lang::get('default.not_found'),
                [true],
                404
            );
        }
        return RelationException::handler($exception, $request);
    }
}
