<?php

namespace Database\Seeders\Prod\Base;

use App\Models\Base\File;
use App\Models\Base\Template;
use App\Writers\Payment\RosselhozWriter;
use App\Writers\Payment\SberWriter;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        File::createChildren(Template::class, [
            'disk'          => 'templates',
            'path'          => 'payment',
            'origin_name'   => 'RaportToBank_Sber.blade.php',
            'name'          => 'RaportToBank_Sber.blade.php',

            'description'   => 'Файл выгрузки выплаты в Сбербанк',
            'writer' => SberWriter::class,
        ]);

        File::createChildren(Template::class, [
            'disk'          => 'templates',
            'path'          => 'payment',
            'origin_name'   => 'RaportToBank_UralSib.blade.php',
            'name'          => 'RaportToBank_UralSib.blade.php',

            'description'   => 'Файл выгрузки выплаты в Россельхоз банк',
            'writer' => RosselhozWriter::class,
        ]);
    }
}
