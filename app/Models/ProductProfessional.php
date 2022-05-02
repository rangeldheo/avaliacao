<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductProfessional extends Model
{
    public const TABLE = 'product_professionals';

    protected $fillable = [
        'product_id',
        'professional_id',
        'status'
    ];
}
