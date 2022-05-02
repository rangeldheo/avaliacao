<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Status extends Enum
{
    const INACTIVE = 0;
    const ACTIVE   = 1;
    const BLOCKED  = 2;
    const CANCELED = 3;

    public static function getDescription($status): string
    {
        $value = [
            0 => 'Em avaliação',
            1 => 'Ativo',
            2 => 'Bloqueado',
            3 => 'Cancelado',
        ];
        return $value[$status];
    }
}
