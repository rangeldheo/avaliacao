<?php

namespace App\Scopes\Schedule\ChainsOfResponsability;

use App\Alias\ScheduleAlias;
use Illuminate\Http\Request;

/**
 * Define o intervalo de data da pesquisa baseado no dia seguinte ao atual
 */
class NextDay extends PeriodAbstract
{
    public function handler(Request $request)
    {
        $hasAlias = $request->get(ScheduleAlias::SEARCH_PERIOD);

        if ($hasAlias == 'next_day') {
            $this->carbon->addDay($this->increment);
            $nextDay = $this->carbon->toDateString();

            $initial = $nextDay . ' ' . self::INITIAL_HOUR;
            $final   = $nextDay . ' ' . self::FINAL_HOURS;
            $this->setInterval($initial, $final);
        }
        $currentWeek = new CurrentWeek();
        return $currentWeek->handler($request);
    }
}