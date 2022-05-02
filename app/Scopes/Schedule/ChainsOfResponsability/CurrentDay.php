<?php

namespace App\Scopes\Schedule\ChainsOfResponsability;

use App\Alias\ScheduleAlias;
use Illuminate\Http\Request;

/**
 * Define o intervalo de data da pesquisa baseado no dia
 * atual iniciando pela hora 00:00:00 até 23:59:59
 */
class CurrentDay extends PeriodAbstract
{
    public function handler(Request $request)
    {
        $hasAlias = $request->get(ScheduleAlias::SEARCH_PERIOD);

        if ($hasAlias == 'current_day') {
            $date = $this->carbon->toDateString();
            $initial = $date . ' ' . self::INITIAL_HOUR;
            $final   = $date . ' ' . self::FINAL_HOURS;
            $this->setInterval($initial, $final);
        }
        $nextDay = new NextDay();
        return $nextDay->handler($request);
    }
}