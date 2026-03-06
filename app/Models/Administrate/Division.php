<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__divisions';

    protected $fillable = [
        'name'
    ];
}
