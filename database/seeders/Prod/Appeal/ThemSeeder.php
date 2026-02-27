<?php

namespace Database\Seeders\Prod\Appeal;

use App\Models\Appeal\Them;
use App\Models\Appeal\ThemGroup;
use Illuminate\Database\Seeder;

class ThemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThemGroup::create(['code' => 'stpo',           'name' => 'СТПО']);
        ThemGroup::create(['code' => 'technic',        'name' => 'Оборудование']);
        ThemGroup::create(['code' => 'asp',            'name' => 'АСП']);
        ThemGroup::create(['code' => 'security',       'name' => 'Безопасность']);
        ThemGroup::create(['code' => 'transport',      'name' => 'Транспортный проект']);
        ThemGroup::create(['code' => 'other',          'name' => 'Прочее']);

        Them::create(['group_id' => ThemGroup::byCode('stpo')->id,      'name' => 'Вопрос | Предложение']);

        Them::create(['group_id' => ThemGroup::byCode('technic')->id,   'name' => 'Неполадки с компьютером']);
        Them::create(['group_id' => ThemGroup::byCode('technic')->id,   'name' => 'Неполадки с МФУ | принтером']);
        Them::create(['group_id' => ThemGroup::byCode('technic')->id,   'name' => 'Неполадки с IP-телефоном']);
        Them::create(['group_id' => ThemGroup::byCode('technic')->id,   'name' => 'Моей темы нет в списке']);

        Them::create(['group_id' => ThemGroup::byCode('asp')->id,       'name' => 'Объединение ПКУ']);
        Them::create(['group_id' => ThemGroup::byCode('asp')->id,       'name' => 'Адреса']);
        Them::create(['group_id' => ThemGroup::byCode('asp')->id,       'name' => 'Тарифы ЖКУ']);
        Them::create(['group_id' => ThemGroup::byCode('asp')->id,       'name' => 'Моей темы нет в списке']);

        Them::create(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'ЭЦП']);
        Them::create(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'Антивирус']);
        Them::create(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'Континент']);
        Them::create(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'VIPNET']);
        Them::create(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'Моей темы нет в списке']);

        Them::create(['group_id' => ThemGroup::byCode('transport')->id, 'name' => 'WP']);
        Them::create(['group_id' => ThemGroup::byCode('transport')->id, 'name' => 'Карта жителя']);
        Them::create(['group_id' => ThemGroup::byCode('transport')->id, 'name' => 'Моей темы нет в списке']);

        Them::create(['group_id' => ThemGroup::byCode('other')->id,     'name' => 'Моей темы нет в списке']);
    }
}
