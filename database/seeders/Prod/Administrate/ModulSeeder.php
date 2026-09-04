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
        ### Administrate
        ##################################################
        // Divisions
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Города',
            'route_name'    => 'administrate.cities.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Организации',
            'route_name'    => 'administrate.divisions.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);

        // Moduls
        Modul::firstOrCreate([
            'name'          => 'Группы модулей',
            'route_name'    => 'administrate.modul-groups.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        Modul::firstOrCreate([
            'name'          => 'Модули',
            'route_name'    => 'administrate.moduls.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);

        // Banks
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Банки',
            'route_name'    => 'administrate.banks.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Виды финансирования',
            'route_name'    => 'administrate.financing-types.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);

        // Payments
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Выплаты',
            'route_name'    => 'administrate.payments.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);

        // Laws
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Законы',
            'route_name'    => 'administrate.laws.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);

        ### Appeals
        ##################################################
        Modul::firstOrCreate([
            'name' => 'Обращения',
            'route_name' => 'appeal.appeals.index',
        ]);

        ### FSD
        ##################################################
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Запросы СФР',
            'route_name'    => 'sfr.fsd.sfr-files.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Категории проезда',
            'route_name'    => 'sfr.fsd.transit-categories.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Категории СФР',
            'route_name'    => 'sfr.fsd.sfr-payment-categories.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Категории АСП',
            'route_name'    => 'sfr.fsd.asp-payment-categories.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Файлы выплат',
            'route_name'    => 'sfr.fsd.payment-files.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Файлы проезда',
            'route_name'    => 'sfr.fsd.transit-files.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);

        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Эквиваленты по проезду',
            'route_name'    => 'sfr.fsd.transit-equivalents.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);

        ### Payments
        ##################################################
        Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Календарь выплат',
            'route_name'    => 'payment.events.index',
            'group_id'      => ModulGroup::byCode('payments')->id,
        ]);
    }
}
