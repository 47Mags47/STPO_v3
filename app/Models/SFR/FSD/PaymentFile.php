<?php

namespace App\Models\SFR\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__payment_files';

    protected $fillable = [
        'in_date',
        'division_id',
        'file_id',
    ];

    protected function casts(): array
    {
        return [
            'in_date' => 'date',
        ];
    }

    public static string|null $storage_file_disk = 'fsd';
    public static string|null $storage_file_path = 'payment';
    public static string|null $channel = 'sfr.fsd.payment-files';

    ### Методы
    ##################################################
    public static function checkExist(string $origin_name, ?int $type_id = null, ?string $in_date = null){
        $query = self::query();
        $query->whereHas('file', fn($query) => $query->where('origin_name', $origin_name));

        if($type_id !== null)
            $query->where('type_id', $type_id);

        if($in_date !== null)
            $query->where('in_date', $in_date);

        return $query->count() > 0;
    }

    ### Связи
    ##################################################
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'file_id');
    }
}
