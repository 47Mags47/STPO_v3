<?php

namespace App\Models\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'fsd__payment_files';

    protected $fillable = [
        'in_month',
        'file_id',
        'type_id'
    ];

    public static string|null $storage_file_disk = 'fsd';
    public static string|null $storage_file_path = 'payment';


    protected function casts(): array
    {
        return [
            'in_month' => 'date',
        ];
    }

    ### Методы
    ##################################################
    public static function checkExist(string $origin_name, ?int $type_id = null, ?string $in_month = null){
        $query = self::query();
        $query->whereHas('file', fn($query) => $query->where('origin_name', $origin_name));

        if($type_id !== null)
            $query->where('type_id', $type_id);

        if($in_month !== null)
            $query->where('in_month', $in_month);

        return $query->count() > 0;
    }

    ### Связи
    ##################################################
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'file_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class, 'type_id');
    }
}
