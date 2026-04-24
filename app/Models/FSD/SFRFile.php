<?php

namespace App\Models\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SFRFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'fsd__sfr_files';

    protected $fillable = [
        'region_code',
        'sign_code',
        'in_date',
        'npp_for_month',
        'file_id',
    ];

    protected function casts(): array
    {
        return [
            'in_date' => 'date',
        ];
    }

    public static string|null $StorageFileDisk = 'fsd';
    public static string|null $StorageFilePath = 'sfr';

    ### Связи
    ##################################################
    public function recipients(): HasMany
    {
        return $this->hasMany(Recipient::class, 'file_id');
    }

    public function payments()//: HasMany
    {
        $paymentTableName = Payment::getTableName();
        $paymentFileTableName = PaymentFile::getTableName();

        $periodStart = $this->recipients()->min('date_start');
        $periodEnd = $this->recipients()->max('date_end');

        return
            $this
                ->hasManyThrough(Payment::class, Recipient::class, 'file_id', 'SNILS', 'id', 'SNILS')
                ->join($paymentFileTableName, $paymentTableName . '.file_id', '=', $paymentFileTableName . '.id')
                ->whereBetween($paymentFileTableName . '.in_month', [$periodStart, $periodEnd]);
    }

    public function transits()//:
    {
        $recipientsTable = TransitRecipient::getTableName();
        $categoriesTable = TransitCategory::getTableName();
        $equivalentsTable = TransitEquivalent::getTableName();

        $periodStart = $this->recipients()->min('date_start');
        $periodEnd = $this->recipients()->max('date_end');

        return $this
            ->hasManyThrough(TransitRecipient::class, Recipient::class, 'file_id', 'SNILS', 'id', 'SNILS')
            ->join($categoriesTable, $recipientsTable . '.wp_category_id', '=', $categoriesTable . '.wp_category_id')
            ->join($equivalentsTable, $categoriesTable . '.id', '=', $equivalentsTable . '.category_id')
            ->where($recipientsTable . '.date_start', '<', $periodEnd)
            ->where($recipientsTable . '.date_end', '>', $periodStart);
    }
}
