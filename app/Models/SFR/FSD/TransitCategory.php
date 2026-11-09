<?php

namespace App\Models\SFR\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransitCategory extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__transit_categories';

    protected $fillable = [
        'name',
        'wp_category_id'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function equivalent(): HasOne
    {
        return $this->hasOne(TransitEquivalent::class, 'category_id');
    }
}
