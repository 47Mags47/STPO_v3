<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__payments';

    protected $fillable = [
        'code',
        'name',
        'kbk'
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function law(): BelongsTo {
        return $this->belongsTo(Law::class, 'law_id');
    }
}
