<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Theme extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'appeal__themes';

    protected $fillable = [
        'name',
        'group_id',
    ];

    ### Связи
    ##################################################
    public function group(): BelongsTo
    {
        return $this->belongsTo(ThemeGroup::class, 'group_id');
    }
}
