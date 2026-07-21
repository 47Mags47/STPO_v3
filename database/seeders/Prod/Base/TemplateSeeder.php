<?php

namespace Database\Seeders\Prod\Base;

use App\Models\Base\File;
use App\Models\Base\Template;
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
        ]);
    }
}
