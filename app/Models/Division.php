<?php

namespace App\Models;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__divisions';

    protected $fillable = [
        'name'
    ];
}
