<?php

namespace App\Models\Appeal;

use App\Classes\BaseModel;
use App\Models\Base\Chat;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appeal extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'appeal__appeals';

    protected $fillable = [
        'comment',
        'chat_id',
        'sender_id',
        'worker_id',
        'status_id',
        'them_id',
    ];

    ### SCOPES
    ##################################################
    public function scopeHasPermission(Builder $builder)
    {
        return $builder
            ->whereKey(null)
            ->orWhere(function ($query) {
                $query
                    ->where('sender_id', user()->id)
                    ->orWhere('worker_id', user()->id);

                if (user()->hasPermission('appeal_work'))
                    $query->orWhereNot('sender_id', user()->id);
            })
            ->orderBy('created_at', 'desc');
    }

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

    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function them(): BelongsTo
    {
        return $this->belongsTo(Them::class, 'them_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
