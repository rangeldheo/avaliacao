<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Facades\Lang;

/**
 * Encapsulamento dos status dos agendamentos
 * SCHEDULED    = 0 agendado;
 * ANSWERING    = 1 atendendo;
 * CANCELED     = 2 cancelado;
 * RESCHEDULED  = 3 reagendado;
 * COMPLETED    = 4 concluído;
 */
final class ScheduleStatus extends Enum
{
    const UNKNOWN      = -1;
    const SCHEDULED    = 0;
    const ANSWERING    = 1;
    const CANCELED     = 2;
    const RESCHEDULED  = 3;
    const COMPLETED    = 4;

    public static function getDescription($status): string
    {
        $value = [
            0 => 'agendado',
            1 => 'atendendo',
            2 => 'cancelado',
            3 => 'reagendado',
            4 => 'concluído',
        ];
        return $value[$status] ?? Lang::get('default.unknown');
    }
}
//agendado, atendendo, cancelado, reagendado, concluído
//scheduled, answering, canceled, rescheduled, completed