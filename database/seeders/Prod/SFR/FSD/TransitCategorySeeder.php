<?php

namespace Database\Seeders\Prod\SFR\FSD;

use App\Models\SFR\FSD\TransitCategory;
use Illuminate\Database\Seeder;

class TransitCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransitCategory::create(['wp_category_id' => 1,      'name' => 'Ветераны труда']);
        TransitCategory::create(['wp_category_id' => 2,      'name' => 'Труженики тыла']);
        TransitCategory::create(['wp_category_id' => 3,      'name' => 'Реабилитированные лица и лица, пострадавшие от политических репрессий']);
        TransitCategory::create(['wp_category_id' => 4,      'name' => 'Пострадавшие']);
        TransitCategory::create(['wp_category_id' => 5,      'name' => 'Многодетные матери']);
        TransitCategory::create(['wp_category_id' => 6,      'name' => 'Отдельных категорий приемных родителей']);
        TransitCategory::create(['wp_category_id' => 7,      'name' => 'Отдельные категории граждан (Герои Кузбасса, почетные граждане КО, медали «За особый вклад в развитие Кузбасса трёх степеней»)']); // ?
        TransitCategory::create(['wp_category_id' => 8,      'name' => 'Инвалиды']);
        TransitCategory::create(['wp_category_id' => 9,      'name' => 'Дети-инвалиды']);
        TransitCategory::create(['wp_category_id' => 10,     'name' => 'Инвалиды ВОВ']);
        TransitCategory::create(['wp_category_id' => 11,     'name' => 'Участники войны']);                               // ?
        TransitCategory::create(['wp_category_id' => 12,     'name' => 'Жители блокадного Ленинграда']);
        TransitCategory::create(['wp_category_id' => 13,     'name' => 'Бывшие несовершеннолетние узники концлагерей']);
        TransitCategory::create(['wp_category_id' => 14,     'name' => 'Члены семей погибших (умерших) граждан ВОВ']);
        TransitCategory::create(['wp_category_id' => 15,     'name' => 'Ветеран ст. 17']);                                // ?
        TransitCategory::create(['wp_category_id' => 16,     'name' => 'Ветераны б/д']);
        TransitCategory::create(['wp_category_id' => 17,     'name' => 'Лица, подвергшиеся воздействию радиации']);
        TransitCategory::create(['wp_category_id' => 18,     'name' => 'Ветераны ВОВ ст. 19']);
        TransitCategory::create(['wp_category_id' => 19,     'name' => 'Герои РФ, герои СССР, ПК ордена Славы, герои соц. труда, орден славы трёх степеней']);
        TransitCategory::create(['wp_category_id' => NULL,   'name' => 'Пенсионеры']);
    }
}
