<?php

namespace App\Models\FSD;

use App\Classes\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipient extends BaseModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'fsd__recipients';
    public $timestamps = false;

    protected $fillable = [
        'division_code',
        'first_name',
        'last_name',
        'middle_name',
        'SNILS',

        'file_id',
        'status_id',
    ];

    ### Связи
    ##################################################
    public function status(): BelongsTo
    {
        return $this->belongsTo(RecipientStatus::class, 'status_id');
    }
}
