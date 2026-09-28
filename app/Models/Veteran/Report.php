<?php

namespace App\Models\Veteran;

use App\Classes\BaseModel;
use App\Models\Administrate\Division;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends BaseModel
{
    use HasFactory, SoftDeletes;

    ### Настройки
    ##################################################
    protected $table = 'veteran__reports';

    protected $fillable = [
        'start_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'date',
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
    public function records(): HasMany
    {
        return $this->HasMany(Record::class, 'report_id');
    }
}
