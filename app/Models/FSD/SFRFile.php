<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use App\Traits\ThisFileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SFRFile extends BaseModel
{
    use ThisFileModel, HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'fsd__sfr_files';

    protected $fillable = [
        'file_id',
        'region_code',
        'sign_code',
        'in_date',
        'npp_for_month',
    ];

    protected function casts(): array
    {
        return [
            'in_date' => 'date',
        ];
    }

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    //
}
