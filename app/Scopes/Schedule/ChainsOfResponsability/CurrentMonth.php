<?php

namespace App\Scopes\Schedule\ChainsOfResponsability;

use App\Alias\ScheduleAlias;
use Illuminate\Http\Request;

/**
 * Define o intervalo de data da pesquisa baseado no mês atual
 */
class CurrentMonth extends PeriodAbstract
{
    public function handler(Request $request)
    {
        $hasAlias = $request->get(ScheduleAlias::SEARCH_PERIOD);

        if ($hasAlias == 'current_month') {
            $this->carbon->now();
            $firstOfMonth  = $this->carbon->firstOfMonth()->toDateString();
            $lastOfMonth = $this->carbon->lastOfMonth()->toDateString();

            $initial = $firstOfMonth . ' ' . self::INITIAL_HOUR;
            $final   = $lastOfMonth . ' ' . self::FINAL_HOURS;

            $this->setInterval($initial, $final);
            return $this;
        }

        $nextDay = new NextMonth();
        return $nextDay->handler($request);
    }
}