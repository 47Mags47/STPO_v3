<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    public $timestamps = false;

    protected $table = 'fsd__payments';

    protected $fillable = [
        'raport_date',
        'type_number',
        'type_name',
        'amount',
        'amount_other',
        'start_date',
        'end_date',
        'file_id',
        'recipient_id',
    ];
}
