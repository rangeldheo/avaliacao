<?php

namespace App\Models;

use App\Http\Requests\Company\CompanySearch;
use App\Services\SearchServices;
use App\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use \App\Traits\Uuid;

    public const PRIMARY_KEY = 'company_id';
    public const RELATION_PROFESSIONALS = CompanyProfessionals::TABLE;

    protected $fillable = [
        'user_id',
        'status',
        'corporate_name',
        'corporate_doc',
        'manager',
        'status',
        'mobile_phone',
        'web_site',
        'zipcode',
        'street',
        'complement',
        'number',
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
    protected $allowedFieldsForLike = [
        'corporate_name',
        'corporate_doc',
        'manager',
        'mobile_phone',
        'web_site',
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
        'status',
        'user_id',
        'zipcode'
    ];

    /**
     * Models de relacionamento que podem ser
     * geridos pelo sistema de attachs/dettach/sync
     * @var array
     */
    public $syncModels = [
        'professionals'
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
        return $this->hasMany(Product::class);
    }

    public function professionals()
    {
        // return $this->belongsToMany(
        //     Professional::class,
        //     self::RELATION_PROFESSIONALS
        // );
        return $this->hasMany(Professional::class);
    }

    /**
     * Escopo que aceita qualquer consulta por campo
     * do modelo que for recuperado no $request->only()
     * @param Builder $query
     * @param CompanySearch $request
     * @return Paginator
     */
    public function scopeSearch(
        Builder $query,
        CompanySearch $request = null
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