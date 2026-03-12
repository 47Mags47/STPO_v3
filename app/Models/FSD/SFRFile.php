<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use App\Traits\ThisFileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SFRFile extends BaseModel
{
    use ThisFileModel, HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'fsd__sfr_files';

    protected $fillable = [
        'region_code',
        'sign_code',
        'in_date',
        'npp_for_month',
        'file_id',
    ];

    protected function casts(): array
    {
        return [
            'in_date' => 'date',
        ];
    }

    ### Связи
    ##################################################
    public function recipients(): HasMany
    {
        return $this->hasMany(Recipient::class, 'file_id');
    }

    public function paymentFiles(): HasMany
    {
        return $this->hasMany(PaymentFile::class, 'sfr_file_id');
    }

    public function payments(): HasManyThrough
    {
        return $this->through('paymentFiles')->has('payments');
    }
}
