<?php

namespace App\Scopes\Schedule\ChainsOfResponsability;

use Carbon\Carbon;
use Illuminate\Http\Request;

abstract class PeriodAbstract implements PeriodInterface
{
    const INITIAL_HOUR = '00:00:00';
    const FINAL_HOURS = '23:59:59';

    /**
     * Data inicial da busca
     *
     * @var timestamp
     */
    protected $initial;

    /**
     * Data final da busca
     *
     * @var timestamp
     */
    protected $final;

    /**
     * Boblioteca Carbon para manioulação de datas
     *
     * @var Carbon
     */
    protected $carbon;

    /**
     * Incrementa as datas com valores passados na queryParam ?add=VALOR_INTEIRO
     * Esse incremento pode ser usado para adicionar dias,semana ou meses nas
     * buscas usando as classes NextDay,NextWeek,NextMoth.
     * Ao adicionar um valor atráves do ?add=VALOR o cliente poderá
     * navegar pelo calendário
     *
     * @var integer
     */
    protected $increment = 1;

    public function __construct()
    {
        $this->carbon = new Carbon();

        $hasAddOnRequest = Request()->get('add');
        if ($hasAddOnRequest) {
            $this->increment = (int) $hasAddOnRequest;
        }
    }

    public function setInterval($initial, $final)
    {
        $this->initial = $initial;
        $this->final = $final;
    }

    public function getInitial()
    {
        return $this->initial;
    }
    public function getFinal()
    {
        return $this->final;
    }
}