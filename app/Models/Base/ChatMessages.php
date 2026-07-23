<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Models\Base\Chat;
use App\Models\Base\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessages extends BaseModel
{
    use HasFactory, SoftDeletes;

    ### Настройки
    ##################################################
    protected $table = 'base__chat_messages';

    protected $fillable = [
        'message',
        'readed',
        'context',
        'chat_id',
        'file_id',
    ];

    protected function casts(): array
    {
        return [
            'readed' => 'boolean',
        ];
    }

    ### Связи
    ##################################################
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
