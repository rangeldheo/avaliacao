<?php

namespace App\Services;

use App\Alias\ScheduleAlias;
use App\Scopes\Schedule\Period;
use Illuminate\Http\Request;

/**
 * Em casos onde o agendamento é chamando como uma relations
 * o validador ScheduleSearch [FormRequest] não é chamado e não podemos usá-lo
 * para validar a requisição
 * Esse ajuste serve para corrigir todas as requests que não vão passar pelo
 * ScheduleSearch
 */
class AdjustRequestSchedule
{
    /**
     *
     * @param mixed $request
     *
     * @return mixed
     */
    public static function adjust(Request $request)
    {
        $searchWithouAlias =
            !in_array($request[ScheduleAlias::SEARCH_PERIOD], Period::$allowedAlias);

        if ($searchWithouAlias) {
            $periods = explode(',', $request[ScheduleAlias::SEARCH_PERIOD]);
            $request['initial_date'] = $periods[0];
            $request['final_date'] = $periods[1] ?? null;

            $request->validate([
                'initial_date' => 'sometimes|date',
                'final_date' => 'sometimes|date|after:initial_date',
            ]);
        }

        return $request;
    }
}