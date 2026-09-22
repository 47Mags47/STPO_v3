<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancingType extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__financing_types';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sfr_fsd_code',
        'asp_name',
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
