<?php

namespace App\Models\Veteran;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Date extends BaseModel
{
    use HasFactory, SoftDeletes;

    ### Настройки
    ##################################################
    protected $table = 'veteran__dates';

    protected $fillable = [
        'in_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'in_date'   => 'date',
            'is_active' => 'boolean',
        ];
    }

    ### Методы
    ##################################################
    public static function getActive(): self
    {
        $query = self::query()->where('is_active', true);
        return $query->count() > 0
            ? $query->get()->first()
            : abort(404);
    }

    ### Связи
    ##################################################
    public function reports(): HasMany
    {
        return $this->HasMany(Report::class, 'date_id');
    }
}
