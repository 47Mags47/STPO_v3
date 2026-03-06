<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use App\Traits\ThisFileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentFile extends BaseModel
{
    use ThisFileModel, HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'fsd__payment_files';

    protected $fillable = [
        'file_id',
    ];

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'file_id');
    }
}
