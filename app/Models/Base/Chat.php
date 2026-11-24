<?php

namespace App\Models\Base;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Base\ChatMessage;
use App\Models\Appeal\Appeal;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'base__chats';

    protected $fillable = [];

    ### Методы
    ##################################################
    public function notifySubscribers(string $message, ?array $excludeUserIds = []): void
    {
        $this->subscribers
            ->when(
                count($excludeUserIds) > 0,
                fn($subscribers) => $subscribers->reject(fn($subscriber) => in_array($subscriber->id, $excludeUserIds))
            )
            ->each(fn($subscriber) => Notification::factory()->create([
                'recipient_id' => $subscriber->id,
                'message'      => $message,

                'type_id'      => NotificationType::byCode('message'),
                'context'      => ['chat_id' => $this->id],
            ]));
    }

    public function postSystemMessage(string $message){
        ChatMessage::factory()->create([
            'message' => $message,
            'sender_id' => null,
            'is_system' => true,
            'chat_id' => $this->id,
        ]);
    }

    ### Связи
    ##################################################
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chat_id');
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'base__chat_subscribers', 'chat_id', 'user_id');
    }

    public function appeal(): HasOne
    {
        return $this->hasOne(Appeal::class, 'chat_id');
    }
}
