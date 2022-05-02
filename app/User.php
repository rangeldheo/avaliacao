<?php

namespace App;

use App\Http\Requests\User\UserSearch;
use App\Models\Company;
use App\Models\Professional;
use App\Services\SearchServices;
use App\Services\UserServices;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const INCOMPLETE_REGISTRATION  = 0;
    const COMPANY      = 1;
    const PROFESSIONAL = 2;
    const CLIENT       = 3;
    const ADMIN        = 4;
    const INCOMPLETE_REGISTRATION_LABEL = 'incomplete_registration';
    const COMPANY_LABEL      = 'company';
    const PROFESSIONAL_LABEL = 'professional';
    const CLIENT_LABEL       = 'client';
    const ADMIN_LABEL        = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activation_hash',
        'activation_expires',
        'first_login'
    ];

    protected $appends = [
        'type',
        'type_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'first_login' => 'boolean',
    ];

    /**
     * Campos da base de dados que suportam buscas
     *
     * @var array
     */
    protected $allowedFieldsForLike = [
        'name',
        'email'
    ];
    /**
     * Campos da base de dados que suportam buscas
     *
     * @var array
     */
    protected $allowedFieldsForEqual = [];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Converte o password em hash code
     *
     * @param string $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Carrega o profissional relacionado com o cadastro
     * do usuário
     *
     * @return void
     */
    public function professional()
    {
        return $this->hasOne(Professional::class);
    }

    /**
     * Carrega a empresa relacionada com o cadastro
     * do usuário
     *
     * @return void
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Retorna o tipo de cadastro desse usuário
     *
     * @return void
     */
    public function getTypeAttribute()
    {
        return UserServices::defineUserType($this->id);
    }

    /**
     * Retorna o label do tipo de cadastro
     *
     * @return void
     */
    public function getTypeNameAttribute()
    {
        return UserServices::defineUserTypeName($this->id);
    }

    public function isFirstLogin()
    {
        return $this->first_login;
    }
    /**
     * Escopo que aceita qualquer consulta por campo
     * do modelo que for recuperado no $request->only()
     * @param Builder $query
     * @param ProfessionalSearch $request
     * @return Paginator
     */
    public function scopeSearch($query, UserSearch $request = null): Paginator
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
