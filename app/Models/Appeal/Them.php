<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Them extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'appeal__thems';

    protected $fillable = [
        'name',
        'group_id',
    ];

    ### Связи
    ##################################################
    public function group(): BelongsTo
    {
        return $this->belongsTo(ThemGroup::class, 'group_id');
    }
}
