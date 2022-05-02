<?php

namespace App\Alias;

/**
 * Aliás para os campos da tabela de agendamentos
 * Motivação:
 * Evitar a digitação incorreta dos nomes dos campos
 * e obter autocomplete dos nomes dos campos
 */
class ScheduleAlias
{
    const TABLE = 'schedules';

    const SCHEDULED_ID       = 'schedule_id';
    const REAL_START_SERVICE = 'real_start_service';
    const REAL_END_SERVICE   = 'real_end_service';
    const START_SERVICE      = 'start_service';
    const END_SERVICE        = 'end_service';
    const STATUS             = 'status';

    /**
     * Alias para scopes
     */
    const SEARCH_PERIOD    = 'search_period';
    const ORDER_BY  = 'schedule_order';

    /**
     * Alias para filtros
     */
    const PROFESSIONAL_ID = 'professional_id';
    const PRODUCT_ID      = 'product_id';
    const CLIENT_ID       = 'client_id';

    /**
     * Alias para formats
     */
    const START_SERVICE_FORMAT = 'start_service_format';
    const END_SERVICE_FORMAT   = 'end_service_format';
    const REAL_START_FORMAT    = 'real_star_format';
    const REAL_END_FORMAT      = 'real_end_format';
    const STATUS_FORMAT        = 'status_format';
}