<?php

namespace App\Models;

use App\Alias\ScheduleAlias;
use App\Enums\ScheduleStatus;
use App\Http\Requests\Schedule\ScheduleSearch;
use App\Scopes\Schedule\Period;
use App\Services\SearchServices;
use App\Utils\Format;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use \App\Traits\Uuid;
    use \App\Scopes\Schedule\Scopes;

    /**
     * Alias para a chave primaria
     */
    public const PRIMARY_KEY = ScheduleAlias::SCHEDULED_ID;

    protected $fillable = [
        ScheduleAlias::PROFESSIONAL_ID,
        ScheduleAlias::PRODUCT_ID,
        ScheduleAlias::CLIENT_ID,
        ScheduleAlias::REAL_START_SERVICE,
        ScheduleAlias::REAL_END_SERVICE,
        ScheduleAlias::START_SERVICE,
        ScheduleAlias::END_SERVICE,
        ScheduleAlias::STATUS
    ];

    protected $appends = [
        ScheduleAlias::START_SERVICE_FORMAT,
        ScheduleAlias::END_SERVICE_FORMAT,
        ScheduleAlias::REAL_START_FORMAT,
        ScheduleAlias::REAL_END_FORMAT,
        ScheduleAlias::STATUS_FORMAT,
    ];

    /**
     * Campos da base de dados que suportam buscas
     *
     * @var array
     */
    protected $allowedFieldsForLike = [];
    /**
     * Campos da base de dados que suportam buscas
     *
     * @var array
     */
    protected $allowedFieldsForEqual = [
        ScheduleAlias::STATUS,
        ScheduleAlias::PROFESSIONAL_ID,
        ScheduleAlias::PRODUCT_ID,
        ScheduleAlias::CLIENT_ID
    ];

    /**
     * Models de relacionamento que podem ser
     * geridos pelo sistema de attachs/dettach/sync
     * @var array
     */
    public $syncModels = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new Period);
    }

    public function getStartServiceFormatAttribute()
    {
        return Format::formatDate($this->start_service ?? '');
    }

    public function getEndServiceFormatAttribute()
    {
        return Format::formatDate($this->end_service ?? '');
    }

    public function getRealStarFormatAttribute()
    {
        return Format::formatDate($this->real_star_service ?? '');
    }

    public function getRealEndFormatAttribute()
    {
        return Format::formatDate($this->real_end_service ?? '');
    }

    public function getStatusFormatAttribute()
    {
        return ScheduleStatus::getDescription($this->status);
    }

    /**
     * -------------------------------------------------------------------------
     * Relacionamentos
     * -------------------------------------------------------------------------
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Escopo que aceita qualquer consulta por campo
     * do modelo que for recuperado no $request->only()
     * @param Builder $query
     * @param ScheduleSearch $request
     * @return Paginator
     */
    public function scopeSearch(
        Builder $query,
        ScheduleSearch $request = null
    ): Paginator {
        //configura a quantidade de resultados por página
        $config = $request->only(SearchServices::RESULTS);
        $this->setPerPage($config[SearchServices::RESULTS]);

        return SearchServices::search(
            $request,
            $query,
            $this->allowedFieldsForEqual,
            $this->allowedFieldsForLike
        );
    }
}