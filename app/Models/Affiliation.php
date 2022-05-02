<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
    use \App\Traits\Uuid;

    public const PRIMARY_KEY = 'affiliation_id';

    protected $fillable = [
        'company_id',
        'professional_id',
        'justification',
        'start_affiliation',
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
        'company_id',
        'professional_id',
        'status'
    ];
}
