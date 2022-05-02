<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ComissionServices
{
    /**
     * Calcula a comissão sobre o preço do serviço
     * @param Product $product
     *
     * @return float
     */
    public static function calculateCommission(Product $product): float
    {
        if ($product->commission_type == Product::COMISSION_TYPE_PERCENT) {
            $commision = $product->commission * $product->price / 100;
            return $commision;
        }
        return $product->commission;
    }
}