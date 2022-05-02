<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Company;
use App\Models\Professional;
use App\User;

class UserServices
{
    const ALL_FIELDS = 'all';
    const ID         = 'id';
    /**
     * Retorna o usuário logado
     * Abstraí esse serviço pelo seguinte motivo:
     * Caso existam regras de negócios sobre o retorno do usuário logado
     * podemos extender esse método aqui e satisfazer a condição em um único ponto
     * Pode retornar uma array com todos os campos da tabela user
     * ou uma unica coluna
     *
     * @param string $field o campo da tabela usuário que se deseja retornar
     * @return mixed
     */
    public static function getUserLogged(string $field = 'id')
    {
        if ($field === self::ALL_FIELDS) {
            return auth('api')->user();
        }
        return auth('api')->user()->$field;
    }

    /**
     * Define a que grupo o usuário pertence
     * 0 Empresa, 1 Profissional, 2 Cliente
     * @return int
     */
    public static function defineUserType(int $id): int
    {
        $isCompany = Company::where('user_id', $id)->count() > 0;
        if ($isCompany) {
            return User::COMPANY;
        }

        $isProfessional =  Professional::where('user_id', $id)->count() > 0;
        if ($isProfessional) {
            return User::PROFESSIONAL;
        }

        $isClient =  Client::where('user_id', $id)->count() > 0;
        if ($isClient) {
            return User::CLIENT;
        }

        return User::INCOMPLETE_REGISTRATION;
    }
    /**
     * Define a que grupo o usuário pertence
     * 0 Empresa, 1 Profissional, 2 Cliente
     * @return string
     */
    public static function defineUserTypeName(int $id): string
    {
        $isCompany = Company::where('user_id', $id)->count() > 0;
        if ($isCompany) {
            return User::COMPANY_LABEL;
        }

        $isProfessional =  Professional::where('user_id', $id)->count() > 0;
        if ($isProfessional) {
            return User::PROFESSIONAL_LABEL;
        }

        $isClient =  Client::where('user_id', $id)->count() > 0;
        if ($isClient) {
            return User::CLIENT_LABEL;
        }

        return User::INCOMPLETE_REGISTRATION_LABEL;
    }

    /**
     * retorna a empresa vinculada ao usuário logado
     * @return object
     */
    public static function getUserCompany()
    {
        $user = User::with('company')->where('id', self::getUserLogged())
            ->get()
            ->toArray();
        return $user[0]['company']['id'];
    }
}
