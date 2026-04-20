<?php

namespace Database\Seeders\Prod\FSD;

use App\Models\FSD\TransitCategory;
use App\Models\FSD\TransitEquivalent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TransitCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransitCategory::create(['id' => 1,     'wp_category_id' => NULL,   'name' => 'Пенсионеры']);
        TransitCategory::create(['id' => 2,     'wp_category_id' => 1,      'name' => 'Ветераны труда']);
        TransitCategory::create(['id' => 3,     'wp_category_id' => 2,      'name' => 'Труженики тыла']);
        TransitCategory::create(['id' => 4,     'wp_category_id' => 3,      'name' => 'Реабилитированные лица и лица, пострадавшие от политических репрессий']);
        TransitCategory::create(['id' => 5,     'wp_category_id' => 4,      'name' => 'Пострадавшие']);
        TransitCategory::create(['id' => 6,     'wp_category_id' => 5,      'name' => 'Многодетные матери']);
        TransitCategory::create(['id' => 7,     'wp_category_id' => 6,      'name' => 'Отдельных категорий приемных родителей']);
        // ?
        TransitCategory::create(['id' => 8,     'wp_category_id' => 7,      'name' => 'Отдельные категории граждан (Герои Кузбасса, почетные граждане КО, медали «За особый вклад в развитие Кузбасса трёх степеней»)']);
        TransitCategory::create(['id' => 9,     'wp_category_id' => 8,      'name' => 'Инвалиды']);
        TransitCategory::create(['id' => 10,    'wp_category_id' => 9,      'name' => 'Дети-инвалиды']);
        TransitCategory::create(['id' => 11,    'wp_category_id' => 10,     'name' => 'Инвалиды ВОВ']);
        TransitCategory::create(['id' => 12,    'wp_category_id' => 11,     'name' => 'Участники войны']);                               // ?
        TransitCategory::create(['id' => 13,    'wp_category_id' => 12,     'name' => 'Жители блокадного Ленинграда']);
        TransitCategory::create(['id' => 14,    'wp_category_id' => 13,     'name' => 'Бывшие несовершеннолетние узники концлагерей']);
        TransitCategory::create(['id' => 15,    'wp_category_id' => 14,     'name' => 'Члены семей погибших (умерших) граждан ВОВ']);    // ?
        TransitCategory::create(['id' => 16,    'wp_category_id' => 15,     'name' => 'Ветеран ст. 17']);                                // ?
        TransitCategory::create(['id' => 17,    'wp_category_id' => 16,     'name' => 'Ветераны б/д']);
        TransitCategory::create(['id' => 18,    'wp_category_id' => 17,     'name' => 'Лица, подвергшиеся воздействию радиации']);
        TransitCategory::create(['id' => 19,    'wp_category_id' => 18,     'name' => 'Ветераны ВОВ ст. 19']);
        TransitCategory::create(['id' => 20,    'wp_category_id' => 19,     'name' => 'Герои РФ, герои СССР, ПК ордена Славы, герои соц. труда, орден славы трёх степеней']);

        // Пенсионеры
        TransitEquivalent::create(['category_id' => 1,  'equivalent' => 88.00,  'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Ветераны труда
        TransitEquivalent::create(['category_id' => 2,  'equivalent' => 689.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Труженики тыла
        TransitEquivalent::create(['category_id' => 3,  'equivalent' => 689.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Реабилитированные лица и лица, пострадавшие от политических репрессий
        TransitEquivalent::create(['category_id' => 4,  'equivalent' => 704.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);
        TransitEquivalent::create(['category_id' => 5,  'equivalent' => 704.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Пенсионеры
        TransitEquivalent::create(['category_id' => 6,  'equivalent' => 689.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Отдельных категорий приемных родителей
        TransitEquivalent::create(['category_id' => 7,  'equivalent' => 689.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Инвалиды
        TransitEquivalent::create(['category_id' => 9,  'equivalent' => 626.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Дети-инвалиды
        TransitEquivalent::create(['category_id' => 10, 'equivalent' => 626.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Инвалиды ВОВ
        TransitEquivalent::create(['category_id' => 11, 'equivalent' => 685.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Жители блокадного Ленинграда
        TransitEquivalent::create(['category_id' => 13, 'equivalent' => 685.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Бывшие несовершеннолетние узники концлагерей
        TransitEquivalent::create(['category_id' => 14, 'equivalent' => 685.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Ветераны б/д
        TransitEquivalent::create(['category_id' => 17, 'equivalent' => 605.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Лица, подвергшиеся воздействию радиации
        TransitEquivalent::create(['category_id' => 18, 'equivalent' => 605.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Ветераны ВОВ ст. 19
        TransitEquivalent::create(['category_id' => 19, 'equivalent' => 605.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Герои РФ, герои СССР, ПК ордена Славы, герои соц. труда, орден славы трёх степеней
        TransitEquivalent::create(['category_id' => 20, 'equivalent' => 685.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);
    }
}
