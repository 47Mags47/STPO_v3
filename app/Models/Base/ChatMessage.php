<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use App\Models\Appeal\Appeal;
use App\Models\Base\Chat;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends BaseModel
{
    use HasFactory, SoftDeletes;

    ### Настройки
    ##################################################
    protected $table = 'base__chat_messages';

    protected $fillable = [
        'message',

        'is_readed',
        'is_system',

        'chat_id',
        'sender_id',
    ];

    protected function casts(): array
    {
        return [
            'readed' => 'boolean',
            'context' => 'json'
        ];
    }

    public static string|null $storage_file_disk = 'appeals';
    public static string|null $storage_file_path = 'chat';

    public static bool $createInStorage = false;

    ### Связи
    ##################################################
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ChatMessageAttachment::class, 'message_id');
    }
}
