<?php

namespace App\Models\Administrate;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modul extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'administrate__modules';

    protected $fillable = [
        'name',
        'route_name',
        'group_id',
        'in_production',
    ];

    ### Связи
    ##################################################
    public function group(): BelongsTo
    {
        return $this->belongsTo(ModulGroup::class, 'group_id');
    }
}
