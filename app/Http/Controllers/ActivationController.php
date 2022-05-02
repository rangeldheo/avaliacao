<?php

namespace App\Http\Controllers;

use App\Http\Requests\Activation\ActivationRequest;
use App\Http\Resources\ApiResponse;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

/**
 * Classe especialista na ativação de conta de usuário
 */
class ActivationController extends Controller
{
    public function active(string $code)
    {
        $hasBeenActivated = UserRepository::activeUserAccoutn($code);

        $data = [];

        $errorMessage =
            $hasBeenActivated
            ? []
            : ['list' => ['code' => Lang::get('default.code_expired')]];

        $defaultMessage =
            $hasBeenActivated ? Lang::get('default.actived_success') :
            Lang::get('default.code_expired');

        return ApiResponse::return(
            $data,
            $defaultMessage,
            $errorMessage,
            $errorMessage ? 422 : 200
        );
    }
}
