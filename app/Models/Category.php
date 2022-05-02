<?php

namespace App\Models;

use App\Http\Requests\Category\CategorySearch;
use App\Services\SearchServices;
use App\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status'
    ];

    /**
     * Campos da base de dados que suportam buscas [like]
     *
     * @var array
     */
    protected $allowedFieldsForLike = [
        'title',
        'description'
    ];

    /**
     * Campos da base de dados que suportam buscas [=]
     *
     * @var array
     */
    protected $allowedFieldsForEqual = [
        'id',
        'user_id',
        'status'
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

    /**
     * Escopo que aceita qualquer consulta por campo
     * do modelo que for recuperado no $request->only()
     * @param Builder $query
     * @param CategorySearch $request
     * @return Paginator
     */
    public function scopeSearch(Builder $query, CategorySearch $request = null): Paginator
    {
        //configura a quantidade de resultados por página
        $config = $request->only(SearchServices::RESULTS);
        $this->setPerPage($config[SearchServices::RESULTS]);

        return SearchServices::search(
            $request,
            $query,
            $this->allowedFieldsForEqual,
            $this->allowedFieldsForLike,
            ['user']
        );
    }
}