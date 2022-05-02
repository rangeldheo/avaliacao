<?php

namespace App\Utils;

use Carbon\Carbon;

/**
 * Todas as classes mapeadas aqui
 */
class Format
{
    public const LANG_PT = 'pt_br';
    public const LANG_EN = 'en';
    public const CIFRA_PT = 'R$';
    public const CIFRA_EN = '$';

    public static function money($value)
    {
        $lang = self::LANG_PT;
        if ($lang == self::LANG_EN) {
            return self::CIFRA_EN . number_format($value, 2, '.', ',');
        }
        return self::CIFRA_PT . number_format($value, 2, ',', '.');
    }

    /**
     * realiza a normalização de valores float para serem
     * enviados a base de dados
     *
     * @param string $value
     * @return float
     */
    public static function floatNormalize(float $value): float
    {
        $searches = ['R$', '$', 'r$'];
        $value = str_replace($searches, '', $value);
        $value = str_replace(',', '.', $value);
        return  number_format($value, 2, '.', ',');
    }

    /**
     * Formata documento CNPJ ou CPF
     *
     * @param string $cpf_cnpj
     * @return string
     */
    public static function formatDocument(string $cpf_cnpj): string
    {
        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);
        $tipo_dado = NULL;
        if (strlen($cpf_cnpj) == 11) {
            $tipo_dado = "cpf";
        }
        if (strlen($cpf_cnpj) == 14) {
            $tipo_dado = "cnpj";
        }
        switch ($tipo_dado) {
            default:
                $cpf_cnpj_formatado = "Não foi possível definir tipo de dado";
                break;

            case "cpf":
                $bloco_1 = substr($cpf_cnpj, 0, 3);
                $bloco_2 = substr($cpf_cnpj, 3, 3);
                $bloco_3 = substr($cpf_cnpj, 6, 3);
                $dig_verificador = substr($cpf_cnpj, -2);
                $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "-" . $dig_verificador;
                break;

            case "cnpj":
                $bloco_1 = substr($cpf_cnpj, 0, 2);
                $bloco_2 = substr($cpf_cnpj, 2, 3);
                $bloco_3 = substr($cpf_cnpj, 5, 3);
                $bloco_4 = substr($cpf_cnpj, 8, 4);
                $digito_verificador = substr($cpf_cnpj, -2);
                $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;
                break;
        }
        return $cpf_cnpj_formatado;
    }

    /**
     * Formata telefone com 8 e 9 digitos
     *
     * @param string $phone
     * @return string
     */
    public static function formatPhone($phone)
    {
        $tam = strlen(preg_replace("/[^0-9]/", "", $phone));
        if ($tam == 14) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
            return "+" . substr($phone, 0, $tam - 11) . "(" . substr($phone, $tam - 11, 2) . ")" . substr($phone, $tam - 9, 5) . "-" . substr($phone, -4);
        }
        if ($tam == 13) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
            return "+" . substr($phone, 0, $tam - 11) . "(" . substr($phone, $tam - 11, 2) . ")" . substr($phone, $tam - 9, 5) . "-" . substr($phone, -4);
        }
        if ($tam == 12) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
            return "+" . substr($phone, 0, $tam - 10) . "(" . substr($phone, $tam - 10, 2) . ")" . substr($phone, $tam - 8, 4) . "-" . substr($phone, -4);
        }
        if ($tam == 11) { // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
            return "(" . substr($phone, 0, 2) . ")" . substr($phone, 2, 5) . "-" . substr($phone, 7, 11);
        }
        if ($tam == 10) { // COM CÓDIGO DE ÁREA NACIONAL
            return "(" . substr($phone, 0, 2) . ")" . substr($phone, 2, 4) . "-" . substr($phone, 6, 10);
        }
        if ($tam <= 9) { // SEM CÓDIGO DE ÁREA
            return substr($phone, 0, $tam - 4) . "-" . substr($phone, -4);
        }
    }

    /**
     * @param string $date
     * @return string data formatada em Pt_BR
     */
    public static function formatDate(string $date = ''): string
    {
        if (!$date) {
            return 'Não registrado ainda';
        }
        return Carbon::parse($date)->format('d/m/Y H:i:s');
    }
}
