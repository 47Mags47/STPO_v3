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
        ThemGroup::firstOrCreate(['code' => 'stpo',           'name' => 'СТПО']);
        ThemGroup::firstOrCreate(['code' => 'technic',        'name' => 'Оборудование']);
        ThemGroup::firstOrCreate(['code' => 'asp',            'name' => 'АСП']);
        ThemGroup::firstOrCreate(['code' => 'security',       'name' => 'Безопасность']);
        ThemGroup::firstOrCreate(['code' => 'transport',      'name' => 'Транспортный проект']);
        ThemGroup::firstOrCreate(['code' => 'other',          'name' => 'Прочее']);

        Them::firstOrCreate(['group_id' => ThemGroup::byCode('stpo')->id,      'name' => 'Вопрос | Предложение']);

        Them::firstOrCreate(['group_id' => ThemGroup::byCode('technic')->id,   'name' => 'Неполадки с компьютером']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('technic')->id,   'name' => 'Неполадки с МФУ | принтером']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('technic')->id,   'name' => 'Неполадки с IP-телефоном']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('technic')->id,   'name' => 'Моей темы нет в списке']);

        Them::firstOrCreate(['group_id' => ThemGroup::byCode('asp')->id,       'name' => 'Объединение ПКУ']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('asp')->id,       'name' => 'Адреса']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('asp')->id,       'name' => 'Тарифы ЖКУ']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('asp')->id,       'name' => 'Моей темы нет в списке']);

        Them::firstOrCreate(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'ЭЦП']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'Антивирус']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'Континент']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'VIPNET']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('security')->id,  'name' => 'Моей темы нет в списке']);

        Them::firstOrCreate(['group_id' => ThemGroup::byCode('transport')->id, 'name' => 'WP']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('transport')->id, 'name' => 'Карта жителя']);
        Them::firstOrCreate(['group_id' => ThemGroup::byCode('transport')->id, 'name' => 'Моей темы нет в списке']);

        Them::firstOrCreate(['group_id' => ThemGroup::byCode('other')->id,     'name' => 'Моей темы нет в списке']);
    }
}
