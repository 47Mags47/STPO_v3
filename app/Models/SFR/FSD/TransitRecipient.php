<?php

namespace App\Models\SFR\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class TransitRecipient extends BaseModel
{
    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__transit_recipients';

    protected $fillable = [
        'SNILS',
        'date_start',
        'date_end',
        'wp_category_id',
        'file_id',
    ];

    protected function casts(): array
    {
        return [
            'date_start' => 'date',
            'date_end' => 'date',
        ];
    }

    ### Связи
    ##################################################
    public function transitFile(): BelongsTo
    {
        return $this->belongsTo(TransitFile::class, 'file_id');
    }

    public function equivalent(): HasOneThrough
    {
        return $this->hasOneThrough(TransitEquivalent::class, TransitCategory::class, 'wp_category_id', 'category_id', 'wp_category_id', 'id');
    }
}
