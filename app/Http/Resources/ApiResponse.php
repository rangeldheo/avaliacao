<?php

namespace App\Http\Resources;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class ApiResponse
{
    /**
     * Retorno pradronizado da API
     *
     * @param array $data
     * @param null $message
     * @param array $error
     * @param null $statusCode
     *
     * @return [type]
     */
    public static function return($data = [], $message = null, $error = [], $statusCode = 200)
    {
        return Response::json([
            'data'            => $data,
            'error'           => $error,
            'message'         => $message
        ], $statusCode);
    }
}