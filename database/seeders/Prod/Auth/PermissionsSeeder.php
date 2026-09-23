<?php

namespace Database\Seeders\Prod\Auth;

use App\Models\Auth\Permission;
use App\Models\Auth\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['code' => 'permission_assigning',           'name' => 'Назначение разрешений']);

        ### Administrate
        ##################################################
        Permission::create(['code' => 'city_administrate',              'name' => 'Работа со справочником городов',                 'group_id' => PermissionGroup::byCode('glossary_writer')->id]);
        Permission::create(['code' => 'division_administrate',          'name' => 'Работа со справочником организаций',             'group_id' => PermissionGroup::byCode('glossary_writer')->id]);
        Permission::create(['code' => 'banks_administrate',             'name' => 'Работа со справочником банков',                  'group_id' => PermissionGroup::byCode('glossary_writer')->id]);
        Permission::create(['code' => 'financing_types_administrate',   'name' => 'Работа со справочником типов финансирования',    'group_id' => PermissionGroup::byCode('glossary_writer')->id]);
        Permission::create(['code' => 'payments_administrate',          'name' => 'Работа со справочником выплат',                  'group_id' => PermissionGroup::byCode('glossary_writer')->id]);
        Permission::create(['code' => 'laws_administrate',              'name' => 'Работа со справочником законов',                 'group_id' => PermissionGroup::byCode('glossary_writer')->id]);

        ### FSD
        ##################################################
        Permission::create(['code' => 'FSD_worker',                     'name' => 'Загрузка файлов ФСД',                            'group_id' => PermissionGroup::byCode('FSD')->id]);
        Permission::create(['code' => 'FSD_administrator',              'name' => 'Администрирование ФСД',                          'group_id' => PermissionGroup::byCode('FSD')->id]);

        ### Appeals
        ##################################################
        Permission::create(['code' => 'appeal_work',                    'name' => 'Работа с обращениями']);

        ### Payments
        ##################################################
        Permission::create(['code' => 'payment_event_view',             'name' => 'Доступ к календарю выплат',                      'group_id' => PermissionGroup::byCode('payment_work')->id]);
        Permission::create(['code' => 'payment_file_upload',            'name' => 'Загрузка файлов на выплату',                     'group_id' => PermissionGroup::byCode('payment_work')->id]);
        Permission::create(['code' => 'payment_raport_create',          'name' => 'Формирование отчетов по выплате',                'group_id' => PermissionGroup::byCode('payment_work')->id]);

        ### Veteran
        ##################################################
        Permission::create(['code' => 'veteran_work_admin',             'name' => 'Админ формы "Ветеран труда"',                    'group_id' => PermissionGroup::byCode('veteran_work')->id]);
        Permission::create(['code' => 'veteran_work_worker',            'name' => 'Работник формы "Ветеран труда"',                 'group_id' => PermissionGroup::byCode('veteran_work')->id]);
    }
}
