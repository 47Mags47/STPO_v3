<?php

namespace App\Models\SFR\FSD;

use App\Classes\FileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class SFRFile extends FileModel
{
    use HasFactory;

    ### Настройки
    ##################################################
    protected $table = 'sfr__fsd__sfr_files';

    protected $fillable = [
        'in_date',
        'file_id',

        'date_start',
        'date_end',
    ];

    protected function casts(): array
    {
        return [
            'in_date'       => 'datetime:Y-m',
            'date_start'    => 'date',
            'date_end'      => 'date',
        ];
    }

    protected function inDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::make($value),
            set: fn (string $value) => Carbon::make($value)->startOfMonth()->format('Y-m-d'),
        );
    }

    public static string|null $storage_file_disk = 'fsd';
    public static string|null $storage_file_path = 'sfr';
    public static string|null $channel = 'sfr.fsd.sfr-files';

    ### Связи
    ##################################################
    public function resultFiles(): HasMany
    {
        return $this->hasMany(ResultFile::class, 'sfr_file_id')->orderBy('created_at', 'desc');
    }
}
