<?php

namespace Database\Seeders\Prod\Administrate;

use App\Models\Administrate\Modul;
use App\Models\Administrate\ModulGroup;
use App\Models\Auth\Permission;
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
        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Города',
            'route_name'    => 'administrate.cities.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('city_administrate'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Организации',
            'route_name'    => 'administrate.divisions.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('division_administrate'));

        // Banks
        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Банки',
            'route_name'    => 'administrate.banks.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('banks_administrate'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Виды финансирования',
            'route_name'    => 'administrate.financing-types.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('financing_types_administrate'));

        // Payments
        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Выплаты',
            'route_name'    => 'administrate.payments.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('payments_administrate'));

        // Laws
        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Законы',
            'route_name'    => 'administrate.laws.index',
            'group_id'      => ModulGroup::byCode('administrate')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('laws_administrate'));

        ### FSD
        ##################################################
        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Запросы СФР',
            'route_name'    => 'sfr.fsd.sfr-files.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('FSD_administrator'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Категории проезда',
            'route_name'    => 'sfr.fsd.transit-categories.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('FSD_administrator'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Категории СФР',
            'route_name'    => 'sfr.fsd.sfr-payment-categories.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('FSD_administrator'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Категории АСП',
            'route_name'    => 'sfr.fsd.asp-payment-categories.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('FSD_administrator'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Файлы проезда',
            'route_name'    => 'sfr.fsd.transit-files.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('FSD_administrator'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Эквиваленты по проезду',
            'route_name'    => 'sfr.fsd.transit-equivalents.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('FSD_administrator'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Файлы выплат',
            'route_name'    => 'sfr.fsd.payment-files.index',
            'group_id'      => ModulGroup::byCode('FSD_reestrs')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('FSD_worker'));
        $modul->permissions()->attach(Permission::byCode('FSD_administrator'));

        ### Payments
        ##################################################
        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Календарь выплат',
            'route_name'    => 'payment.events.index',
            'group_id'      => ModulGroup::byCode('payments')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('payment_event_view'));

        ### Veteran_work
        ##################################################
        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Отчёты',
            'route_name'    => 'veteran-work.raports.index',
            'group_id'      => ModulGroup::byCode('veteran_work')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('veteran_work_admin'));

        $modul = Modul::firstOrCreate([
            'in_production' => true,
            'name'          => 'Доступ',
            'route_name'    => 'veteran-work.access.index',
            'group_id'      => ModulGroup::byCode('veteran_work')->id,
        ]);
        $modul->permissions()->attach(Permission::byCode('veteran_work_admin'));
        $modul->permissions()->attach(Permission::byCode('veteran_work_worker'));
    }
}
