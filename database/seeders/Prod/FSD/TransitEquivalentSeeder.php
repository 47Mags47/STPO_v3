<?php

namespace Database\Seeders\Prod\FSD;

use App\Models\FSD\TransitCategory;
use App\Models\FSD\TransitEquivalent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TransitEquivalentSeeder extends Seeder
{
    public function getCategoryId($category)
    {
        return TransitCategory::where('wp_category_id', $category)->get()->first()->id;
    }

    public function run(): void
    {
        // Пенсионеры
        TransitEquivalent::create(['category_id' => $this->getCategoryId(null),  'equivalent' => 88.00,  'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Ветераны труда
        TransitEquivalent::create(['category_id' => $this->getCategoryId(1),  'equivalent' => 689.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Труженики тыла
        TransitEquivalent::create(['category_id' => $this->getCategoryId(2),  'equivalent' => 689.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Реабилитированные лица и лица, пострадавшие от политических репрессий
        TransitEquivalent::create(['category_id' => $this->getCategoryId(3),  'equivalent' => 704.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);
        TransitEquivalent::create(['category_id' => $this->getCategoryId(4),  'equivalent' => 704.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Пенсионеры
        TransitEquivalent::create(['category_id' => $this->getCategoryId(5),  'equivalent' => 689.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Отдельных категорий приемных родителей
        TransitEquivalent::create(['category_id' => $this->getCategoryId(6),  'equivalent' => 689.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Инвалиды
        TransitEquivalent::create(['category_id' => $this->getCategoryId(8),  'equivalent' => 626.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Дети-инвалиды
        TransitEquivalent::create(['category_id' => $this->getCategoryId(9), 'equivalent' => 626.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Инвалиды ВОВ
        TransitEquivalent::create(['category_id' => $this->getCategoryId(10), 'equivalent' => 685.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Жители блокадного Ленинграда
        TransitEquivalent::create(['category_id' => $this->getCategoryId(12), 'equivalent' => 685.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Бывшие несовершеннолетние узники концлагерей
        TransitEquivalent::create(['category_id' => $this->getCategoryId(13), 'equivalent' => 685.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Ветераны б/д
        TransitEquivalent::create(['category_id' => $this->getCategoryId(16), 'equivalent' => 605.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Лица, подвергшиеся воздействию радиации
        TransitEquivalent::create(['category_id' => $this->getCategoryId(17), 'equivalent' => 605.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Ветераны ВОВ ст. 19
        TransitEquivalent::create(['category_id' => $this->getCategoryId(18), 'equivalent' => 605.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);

        // Герои РФ, герои СССР, ПК ордена Славы, герои соц. труда, орден славы трёх степеней
        TransitEquivalent::create(['category_id' => $this->getCategoryId(19), 'equivalent' => 685.00, 'date_start' => Carbon::create(2026, 1, 1), 'date_end' => NULL]);
    }
}
