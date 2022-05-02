<?php

namespace App\Models;

use App\Enums\DaysOfWeek;
use App\Http\Requests\OfficeHours\OfficeHoursSearch;
use App\Services\SearchServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Lang;

class OfficeHours extends Model
{
    use \App\Traits\Uuid;

    /**
     * Alias apara a chave primaria
     */
    public const PRIMARY_KEY = 'product_id';

    protected $fillable = [
        'professional_id',
        'week_day',
        'start',
        'end',
        'start_interval',
        'end_interval',
        'observation',
        'status'
    ];

    protected $appends = [
        'week_day_format',
        'work_interval',
    ];

    protected $cast = [];

    /**
     * Campos da base de dados que suportam buscas [like]
     *
     * @var array
     */
    protected $allowedFieldsForLike = [];

    /**
     * Campos da base de dados que suportam buscas [=]
     *
     * @var array
     */
    protected $allowedFieldsForEqual = [
        'professional_id',
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

        static::addGlobalScope(function ($query) {
            return $query->orderBy('week_day');
        });
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function getWeekDayFormatAttribute()
    {
        return DaysOfWeek::getDescription($this->week_day);
    }

    public function getWorkIntervalAttribute()
    {
        $hasWorkInterval =
            !is_null($this->start_interval) && !is_null($this->end_interval);
        if ($hasWorkInterval) {
            return $this->start_interval . ' - ' . $this->end_interval;
        }
        return  Lang::get('default.no_interval_work');
    }

    /**
     * Escopo que aceita qualquer consulta por campo
     * do modelo que for recuperado no $request->only()
     * @param Builder $query
     * @param ProductSearch $request
     * @return Paginator
     */
    public function scopeSearch(Builder $query, OfficeHoursSearch $request = null): Paginator
    {
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