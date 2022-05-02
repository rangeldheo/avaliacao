<?php

namespace App\Models;

use App\Enums\Status;
use App\Http\Requests\Client\ClientSearch;
use App\Services\SearchServices;
use App\User;
use App\Utils\Format;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use \App\Traits\Uuid;
    use \App\Traits\Schedule\RelationsWithSchedule;

    /**
     * Alias para a chave primaria
     */
    public const PRIMARY_KEY = 'client_id';

    protected $fillable = [
        'user_id',
        'document',
        'status',
        'mobile_phone',
        'nickname',
        'zipcode',
        'street',
        'complement',
        'number',
        'district',
        'city',
        'state',
        'country'
    ];

    protected $appends = [
        'document_format',
        'mobile_phone_format',
        'status_format'
    ];

    /**
     * Campos da base de dados que suportam buscas
     *
     * @var array
     */
    protected $allowedFieldsForLike = [
        'document',
        'mobile_phone',
        'nickname',
        'city',
        'state',
        'district',
        'country'
    ];
    /**
     * Campos da base de dados que suportam buscas
     *
     * @var array
     */
    protected $allowedFieldsForEqual = [
        'status',
        'user_id',
        'id',
        'zipcode'
    ];

    /**
     * Models de relacionamento que podem ser
     * geridos pelo sistema de attachs/dettach/sync
     * @var array
     */
    public $syncModels = [];

    /**
     * Retorna os dados de usuário
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDocumentFormatAttribute()
    {
        return Format::formatDocument($this->document);
    }

    public function getMobilePhoneFormatAttribute()
    {
        return Format::formatPhone($this->mobile_phone);
    }

    public function getStatusFormatAttribute()
    {
        return Status::getDescription($this->status);
    }

    /**
     * Escopo que aceita qualquer consulta por campo
     * do modelo que for recuperado no $request->only()
     * @param Builder $query
     * @param ClientSearch $request
     * @return Paginator
     */
    public function scopeSearch(Builder $query, ClientSearch $request = null): Paginator
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