<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Facades\Lang;

final class DaysOfWeek extends Enum
{
    const SUNDAY    = 0;
    const MONDAY    = 1;
    const TUESDAY   = 2;
    const WEDNESDAY = 3;
    const THURSDAY  = 4;
    const FRIDAY    = 5;
    const SATURNDAY = 6;

    public static function getDescription($status): string
    {
        $value = [
            0 => Lang::get('default.days_week.sunday'),
            1 => Lang::get('default.days_week.monday'),
            2 => Lang::get('default.days_week.tuesday'),
            3 => Lang::get('default.days_week.wednesday'),
            4 => Lang::get('default.days_week.thursday'),
            5 => Lang::get('default.days_week.friday'),
            6 => Lang::get('default.days_week.saturnday'),
        ];
        return $value[$status];
    }
}