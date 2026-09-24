<?php

namespace App\Models\Veteran;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends BaseModel
{
    use HasFactory, SoftDeletes;

    ### Настройки
    ##################################################
    protected $table = 'veteran__reports';

    protected $fillable = [
        'start_at'
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'date',
        ];
    }

    ### Методы
    ##################################################
    //

    ### Связи
    ##################################################
    public function records(): HasMany
    {
        return $this->HasMany(Record::class, 'report_id');
    }
}
