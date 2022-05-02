<?php

namespace App\Models;

use App\Enums\Status;
use App\Http\Requests\Professional\ProfessionalSearch;
use App\Services\SearchServices;
use App\User;
use App\Utils\Format;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use \App\Traits\Uuid;
    use \App\Traits\Schedule\RelationsWithSchedule;

    /**
     * Tabela pivot de relacionamento com produtos/serviços
     */
    public const RELATION_PRODUCTS = ProductProfessional::TABLE;

    /**
     * Alias par aa chave primaria
     */
    public const PRIMARY_KEY = 'professional_id';

    protected $fillable = [
        'user_id',
        'company_id',
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
        'district',
        'city',
        'state',
        'country'
    ];
    /**
     * Campos da base de dados que suportam buscas
     *
     * @var array
     */
    protected $allowedFieldsForEqual = [
        'id',
        'company_id',
        'user_id',
        'status'
    ];

    /**
     * Models de relacionamento que podem ser
     * geridos pelo sistema de attachs/dettach/sync
     * @var array
     */
    public $syncModels = [
        'products'
    ];

    /**
     * Retorna os dados de usuário
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            self::RELATION_PRODUCTS,
            self::PRIMARY_KEY,
            Product::PRIMARY_KEY
        );
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function officeHours()
    {
        return $this->hasMany(OfficeHours::class);
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
     * @param ProfessionalSearch $request
     * @return Paginator
     */
    public function scopeSearch(
        Builder $query,
        ProfessionalSearch $request = null
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