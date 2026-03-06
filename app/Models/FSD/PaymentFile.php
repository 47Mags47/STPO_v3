<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use App\Traits\ThisFileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    //
}
