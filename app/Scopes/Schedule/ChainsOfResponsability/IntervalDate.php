<?php

namespace App\Scopes\Schedule\ChainsOfResponsability;

use App\Alias\ScheduleAlias;
use App\Exceptions\ExceptionSearchPeriod;
use App\Exceptions\RelationException;
use App\Scopes\Schedule\Period;
use App\Services\AdjustRequestSchedule;
use Exception;
use Illuminate\Http\Request;

/**
 * Retorna um intervalo de datas quando não tem um
 * aliás como filtro no valor da queryparam schdule_period
 * enviado na Request
 */
class IntervalDate extends PeriodAbstract
{
    public function handler(Request $request)
    {
        $period = $request->get(ScheduleAlias::SEARCH_PERIOD);

        $hasAllowedAlias = in_array($period, Period::$allowedAlias);

        if ($hasAllowedAlias) {
            $currentDate = new CurrentDay();
            $currentDate->handler($request);
            return $currentDate;
        }

        $request = AdjustRequestSchedule::adjust($request);

        $this->setInterval(
            $request->initial_date,
            $request->final_date
        );

        return $this;
    }
}