<?php

namespace App\Models;

use App\Classes\BaseModel;
use App\Traits\ThisFileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Template extends BaseModel
{
    use HasFactory, ThisFileModel;

    ### Настройки
    ##################################################
    protected $table = 'base__templates';

    protected $fillable = [
        'name',
        'file_id',
        'style_id',
        'type_id',
        'chunk',
    ];

    ### Связи
    ##################################################
    public function type(): BelongsTo
    {
        return $this->belongsTo(TemplateType::class, 'type_id');
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(TemplateStyle::class, 'style_id');
    }
}
