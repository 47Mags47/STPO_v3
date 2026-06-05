<?php

namespace Database\Seeders\Prod\Administrate;

use App\Models\Administrate\Modul;
use App\Models\Administrate\ModulGroup;
use Illuminate\Database\Seeder;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modul::firstOrCreate([
            'name' => 'Обращения',
            'route_name' => 'appeal.appeals.index',
        ]);


        // Administrate
        Modul::firstOrCreate([
            'name'          => 'Список групп модулей',
            'route_name'    => 'administrate.modul-groups.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        Modul::firstOrCreate([
            'name'          => 'Список модулей',
            'route_name'    => 'administrate.moduls.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        Modul::firstOrCreate([
            'name'          => 'Список организаций',
            'route_name'    => 'administrate.divisions.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        Modul::firstOrCreate([
            'name'          => 'Список пользователей',
            'route_name'    => 'administrate.users.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        Modul::firstOrCreate([
            'name'          => 'Список шаблонов',
            'route_name'    => 'administrate.templates.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);


        // SFR
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'ФСД СФР',
            'route_name'    => 'fsd.sfr-files.index',
            'group_id'      => ModulGroup::byCode('SFR')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'ФСД Выплаты',
            'route_name'    => 'fsd.payment-files.index',
            'group_id'      => ModulGroup::byCode('SFR')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'ФСД получатели выплат',
            'route_name'    => 'fsd.payment-recipients.index',
            'group_id'      => ModulGroup::byCode('SFR')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'ФСД Проезд',
            'route_name'    => 'fsd.transit-files.index',
            'group_id'      => ModulGroup::byCode('SFR')->id,
        ]);


        // payments
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Календарь выплат',
            'route_name'    => 'payment.events.index',
            'group_id'      => ModulGroup::byCode('payments')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Выплаты',
            'route_name'    => 'payment.payments.index',
            'group_id'      => ModulGroup::byCode('payments')->id,
        ]);
    }
}
