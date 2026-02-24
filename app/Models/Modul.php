<?php

namespace App\Models;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modul extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__modules';

    protected $fillable = [
        'name',
        'route_name',
        'group_id',
        'creator_id',
    ];

    ### Связи
    ##################################################
    public function group(): BelongsTo
    {
        return $this->belongsTo(ModulGroup::class, 'group_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
