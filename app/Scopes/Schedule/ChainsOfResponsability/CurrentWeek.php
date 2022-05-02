<?php

namespace App\Scopes\Schedule\ChainsOfResponsability;

use App\Alias\ScheduleAlias;
use Illuminate\Http\Request;

/**
 * Define o intervalo de data da pesquisa baseado nos próximos 7 dias
 */
class CurrentWeek extends PeriodAbstract
{
    public function handler(Request $request)
    {
        $hasAlias = $request->get(ScheduleAlias::SEARCH_PERIOD);

        if ($hasAlias == 'current_week') {
            $currentDay  = $this->carbon->now()->toDateString();
            $addweek = $this->carbon->addWeek()->toDateString();

            $initial = $currentDay . ' ' . self::INITIAL_HOUR;
            $final   = $addweek . ' ' . self::FINAL_HOURS;

            $this->setInterval($initial, $final);
            return $this;
        }

        $nextDay = new NextWeek();
        return $nextDay->handler($request);
    }
}