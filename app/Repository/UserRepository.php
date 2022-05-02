<?php

namespace App\Repository;

use App\Abstracts\RespositoryAbstract;
use App\Enums\Status;
use App\User;
use Carbon\Carbon;

class UserRepository extends RespositoryAbstract
{
    const JUST_ONE_RESULT = 1;
    const ON_TIME_LIMIT   = '>=';

    /**
     * Ativa a conta de usuário caso o HASH informado
     * seja único e esteja dentro do prazo de expiração
     *
     * @param string $hashCode
     *
     * @return bool
     */
    public static function activeUserAccoutn(string $hashCode): bool
    {
        $getUser = User::where([
            ['activation_hash', $hashCode],
            ['activation_expires', self::ON_TIME_LIMIT, Carbon::now()],
            ['status', Status::INACTIVE]
        ])->get();

        $isHashValid = $getUser->count() === self::JUST_ONE_RESULT;

        if (!$isHashValid) {
            return false;
        }

        $activateUser =  User::find($getUser[0]->id);
        $activateUser->status = Status::ACTIVE;
        $activateUser->email_verified_at = Carbon::now();

        return $activateUser->update();
    }

    /**
     *  Realiza o update no campo firt_login
     *
     * @return boolean
     */
    public static function updateFirstLogin(): bool
    {
        $user = User::find(auth('api')->id());
        if (!$user->isFirstLogin()) {
            return true;
        }
        $user->first_login = 0;
        return $user->update();
    }
}