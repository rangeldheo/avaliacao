<?php

namespace App\Scopes\Schedule;

use App\Alias\ScheduleAlias;
use App\Scopes\Schedule\ChainsOfResponsability\IntervalDate;
use App\Scopes\Schedule\ChainsOfResponsability\PeriodAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Classe de escopo que gera uma consulta BUILDER
 * filtrando um campo entre datas
 */
class Period implements Scope
{
    /**
     * Alias permitidos nas consultas via queryParams
     *
     * @var array
     */
    public static $allowedAlias = [
        'current_day',
        'next_day',
        'current_week',
        'next_week',
        'current_month',
        'next_month',
    ];

    /**
     * @param Builder $builder
     * @param Model $model
     *
     * @return Builder
     */
    public function apply(Builder $builder, Model $model): Builder
    {
        $hasPeriodParam = request()->get(ScheduleAlias::SEARCH_PERIOD) ?? [];

        if (empty($hasPeriodParam)) {
            return $builder;
        }

        $period = $this->getPeriodByAlias();

        return $builder->whereBetween(
            ScheduleAlias::START_SERVICE,
            [
                $period->getInitial(),
                $period->getFinal()
            ]
        );
    }

    /**
     * Inicial uma cadeia de validação de alias para periodos
     * PATTERN: Chains of Responsability
     * Link referencia: https://designpatternsphp.readthedocs.io/pt_BR/latest/Behavioral/ChainOfResponsibilities/README.html
     * @return PeriodAbstract
     */
    private function getPeriodByAlias(): PeriodAbstract
    {
        $period = new IntervalDate();
        return $period->handler(request());
    }
}