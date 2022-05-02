<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AffiliationStatus extends Enum
{
    const STAND_BY = 0;
    const ACTIVE   = 1;
    const BLOCKED  = 2;

    public static function getDescription($status): string
    {
        $value = [
            0 => 'Em avaliação',
            1 => 'Ativo',
            2 => 'Bloqueado',
        ];
        return $value[$status];
    }
}
