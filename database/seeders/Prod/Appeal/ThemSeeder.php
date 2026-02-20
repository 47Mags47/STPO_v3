<?php

namespace Database\Seeders\Prod\Appeal;

use App\Models\AppealThem;
use App\Models\AppealThemGroup;
use Illuminate\Database\Seeder;

class ThemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppealThemGroup::create(['code' => 'stpo',           'name' => 'СТПО']);
        AppealThemGroup::create(['code' => 'technic',        'name' => 'Оборудование']);
        AppealThemGroup::create(['code' => 'asp',            'name' => 'АСП']);
        AppealThemGroup::create(['code' => 'security',       'name' => 'Безопасность']);
        AppealThemGroup::create(['code' => 'transport',      'name' => 'Транспортный проект']);
        AppealThemGroup::create(['code' => 'other',          'name' => 'Прочее']);

        AppealThem::create(['group_id' => AppealThemGroup::byCode('stpo')->id,      'name' => 'Вопрос | Предложение']);

        AppealThem::create(['group_id' => AppealThemGroup::byCode('technic')->id,   'name' => 'Неполадки с компьютером']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('technic')->id,   'name' => 'Неполадки с МФУ | принтером']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('technic')->id,   'name' => 'Неполадки с IP-телефоном']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('technic')->id,   'name' => 'Моей темы нет в списке']);

        AppealThem::create(['group_id' => AppealThemGroup::byCode('asp')->id,       'name' => 'Объединение ПКУ']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('asp')->id,       'name' => 'Адреса']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('asp')->id,       'name' => 'Тарифы ЖКУ']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('asp')->id,       'name' => 'Моей темы нет в списке']);

        AppealThem::create(['group_id' => AppealThemGroup::byCode('security')->id,  'name' => 'ЭЦП']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('security')->id,  'name' => 'Антивирус']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('security')->id,  'name' => 'Континент']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('security')->id,  'name' => 'VIPNET']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('security')->id,  'name' => 'Моей темы нет в списке']);

        AppealThem::create(['group_id' => AppealThemGroup::byCode('transport')->id, 'name' => 'WP']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('transport')->id, 'name' => 'Карта жителя']);
        AppealThem::create(['group_id' => AppealThemGroup::byCode('transport')->id, 'name' => 'Моей темы нет в списке']);

        AppealThem::create(['group_id' => AppealThemGroup::byCode('other')->id,     'name' => 'Моей темы нет в списке']);
    }
}
