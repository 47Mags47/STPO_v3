<?php

namespace Database\Seeders\Prod\Appeal;

use App\Models\Appeal\Theme;
use App\Models\Appeal\ThemeGroup;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThemeGroup::firstOrCreate(['code' => 'stpo',           'name' => 'СТПО']);
        ThemeGroup::firstOrCreate(['code' => 'technic',        'name' => 'Оборудование']);
        ThemeGroup::firstOrCreate(['code' => 'asp',            'name' => 'АСП']);
        ThemeGroup::firstOrCreate(['code' => 'security',       'name' => 'ИБ']);
        ThemeGroup::firstOrCreate(['code' => 'transport',      'name' => 'Транспортный проект']);
        ThemeGroup::firstOrCreate(['code' => 'other',          'name' => 'Прочее']);

        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('stpo')->id,      'name' => 'Вопрос | Предложение']);

        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('technic')->id,   'name' => 'Неполадки с компьютером']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('technic')->id,   'name' => 'Неполадки с МФУ | принтером']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('technic')->id,   'name' => 'Неполадки с IP-телефоном']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('technic')->id,   'name' => 'Неполадки с сетью']);

        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('asp')->id,       'name' => 'Объединение ПКУ']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('asp')->id,       'name' => 'Адреса']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('asp')->id,       'name' => 'Тарифы ЖКУ']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('asp')->id,       'name' => 'Права пользователя']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('asp')->id,       'name' => 'Заявка на погребение']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('asp')->id,       'name' => 'Перенаправить (потерялось) заявление']);

        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('security')->id,  'name' => 'ЭЦП']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('security')->id,  'name' => 'Антивирус']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('security')->id,  'name' => 'Континент']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('security')->id,  'name' => 'VIPNET']);

        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('transport')->id, 'name' => 'WP']);
        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('transport')->id, 'name' => 'Карта жителя']);

        Theme::firstOrCreate(['group_id' => ThemeGroup::byCode('other')->id,     'name' => 'Моей темы нет в списке']);
    }
}
