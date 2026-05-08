<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipient extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    public $timestamps = false;

    protected $table = 'fsd__recipients';

    protected $fillable = [
        'birth',
        'SNILS',

        'file_id',

        'date_start',
        'date_end',
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
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'SNILS', 'SNILS');
    }
}
