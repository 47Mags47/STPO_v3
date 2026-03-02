<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Models\User;
use App\Traits\ThisFileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends BaseModel
{
    use HasFactory, ThisFileModel, SoftDeletes;

    ### Настройки
    ##################################################
    protected $table = 'appeal__messages';

    protected $fillable = [
        'message',
        'readed',
        'file_id',
        'appeal_id',
        'sender_id',
    ];

    protected function casts(): array
    {
        return [
            'readed' => 'boolean',
        ];
    }

    ### Связи
    ##################################################
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function appeal(): BelongsTo
    {
        return $this->belongsTo(Appeal::class, 'appeal_id');
    }
}
