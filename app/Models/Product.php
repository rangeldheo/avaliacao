<?php

namespace App\Models;

use App\Http\Requests\Product\ProductSearch;
use App\Services\ComissionServices;
use App\Services\SearchServices;
use App\User;
use App\Utils\Format;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Product extends Model
{
    use \App\Traits\Uuid;

    /**
     * Define que o valor da comissao do produto
     * será calculado em porcentagem
     * PRICE * COMISSION / 100
     */
    const COMISSION_TYPE_PERCENT = 0;

    /**
     * Define que a comissao do produto foi cadastrada
     * com o valor em dinheiro
     */
    const COMISSION_TYPE_MONETARY   = 1;

    /**
     * Alias apara a chave primaria
     */
    public const PRIMARY_KEY = 'product_id';

    protected $fillable = [
        'company_id',
        'category_id',
        'user_id',
        'title',
        'description',
        'price',
        'commission',
        'commission_type',
        'status'
    ];

    protected $appends = [
        'commission_calcule',
        'price_format',
        'commission_format',
        'commission_type_format',
    ];

    protected $cast = [
        'commission_type.string',
    ];

    /**
     * Campos da base de dados que suportam buscas [like]
     *
     * @var array
     */
    protected $allowedFieldsForLike = [
        'title',
        'description',
        'price',
        'commission',
        'commission_type',
    ];

    /**
     * Campos da base de dados que suportam buscas [=]
     *
     * @var array
     */
    protected $allowedFieldsForEqual = [
        'company_id',
        'category_id',
        'user_id',
        'status',
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

    /**
     * Retorna a categoria do serviço
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Retorna a categoria do serviço
     *
     * @return void
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Retorna o valor da comissão calculada
     *
     * @return string
     */
    public function getCommissionCalculeAttribute(): string
    {
        if ($this->commission_type == self::COMISSION_TYPE_PERCENT) {
            return Lang::get('default.commision_type_percent');
        }

        return Lang::get('default.commision_type_monetary');
    }
    /**
     * Retorna o valor da comissão calculada
     *
     * @return string
     */
    public function getCommissionTypeFormatAttribute(): string
    {
        if ($this->commission_type == self::COMISSION_TYPE_PERCENT) {
            return $this->commission . '%';
        }
        return $this->commission_format;
    }

    public function getPriceFormatAttribute()
    {
        return Format::money($this->price);
    }

    public function getCommissionFormatAttribute()
    {
        return Format::money(ComissionServices::calculateCommission($this));
    }

    /**
     * Escopo que aceita qualquer consulta por campo
     * do modelo que for recuperado no $request->only()
     * @param Builder $query
     * @param ProductSearch $request
     * @return Paginator
     */
    public function scopeSearch(Builder $query, ProductSearch $request = null): Paginator
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