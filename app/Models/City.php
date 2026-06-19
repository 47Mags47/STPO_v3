<?php

namespace App\Models;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Division;

class City extends BaseModel
{
    //

    ### Настройки
    ##################################################
    protected $table = 'main_cities';

    protected $fillable = [
        'id',
        'name'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function divisions(): HasMany {
        return $this->hasMany(Division::class);
    }
}
