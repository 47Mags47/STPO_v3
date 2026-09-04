<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Administrate\Division;

class City extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__cities';

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
