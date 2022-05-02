<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Serviços centralizados para ativação da conta de usuário
 */
class ActivationServices
{
    /**
     * Gera uma hash unica para validação da conta de usuário
     * @param string $string
     *
     * @return string
     */
    public static function hashGenerate(string $string): string
    {
        $charsForRemove = ['$', '/', '\\', '.', '%', '&', '@', '#'];
        return str_replace($charsForRemove, '', Hash::make(Str::random(10) . $string));
    }
}