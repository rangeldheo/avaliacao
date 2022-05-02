<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfessionals extends Model
{
    public const TABLE = 'company_professionals';

    protected $fillable = [
        'company_id',
        'professional_id',
    ];
}
