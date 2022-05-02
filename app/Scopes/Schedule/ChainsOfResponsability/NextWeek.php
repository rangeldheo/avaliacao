<?php

namespace App\Scopes\Schedule\ChainsOfResponsability;

use App\Alias\ScheduleAlias;
use Illuminate\Http\Request;

/**
 * Define o intervalo de data da pesquisa baseado na proxima semana
 */
class NextWeek extends PeriodAbstract
{
    public function handler(Request $request)
    {
        $hasAlias = $request->get(ScheduleAlias::SEARCH_PERIOD);

        if ($hasAlias == 'next_week') {
            $this->carbon->now();

            $nextWeek  = $this->carbon->addWeeks($this->increment)
                ->toDateString();

            $finalNextWeek  = $this->carbon->addWeeks()
                ->toDateString();

            $initial = $nextWeek . ' ' . self::INITIAL_HOUR;
            $final   = $finalNextWeek . ' ' . self::FINAL_HOURS;

            $this->setInterval($initial, $final);
            return $this;
        }

        $nextDay = new CurrentMonth();
        return $nextDay->handler($request);
    }
}