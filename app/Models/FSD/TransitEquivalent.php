<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransitEquivalent extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'fsd__transit_equivalents';

    protected $fillable = [
        'equivalent',
        'date_start',
        'date_end',
        'category_id',
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function category(): BelongsTo
    {
        return $this->belongsTo(TransitCategory::class, 'category_id');
    }
}
