<?php

namespace Database\Seeders\Prod\SFR\FSD;

use App\Models\SFR\FSD\SFRPaymentCategory;
use Illuminate\Database\Seeder;

class SFRPaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SFRPaymentCategory::create(['pay_number' => '1', 'name' => 'ЕДВ по оплате услуги телефонов связи']);
        SFRPaymentCategory::create(['pay_number' => '2', 'name' => 'Компенсация на оплату ЖКУ']);
        SFRPaymentCategory::create(['pay_number' => '1', 'name' => 'Компенсационные выплаты в связи с расходами по оплате  услуг местной телефонной связи, абонентской платы за пользование радиотрансляционной точкой, коллективной антенной (постановление №475)']);
        SFRPaymentCategory::create(['pay_number' => '2', 'name' => 'Компенсационные выплаты в связи с расходами по оплате жилых помещений и коммунальных услуг (постановление №475)']);
        SFRPaymentCategory::create(['pay_number' => '2', 'name' => 'Ежемесячная денежная выплата на частичную оплату жилого помещения и коммунальных услуг отдельным категориям граждан (15-ОЗ)']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Ежемесячная денежная компенсация на хлеб пенсионерам, получавшим пенсию по состоянию на 31.03.2004']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Пенсия Кемеровской области']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Денежная выплата отдельным категориям граждан взамен получения ими продуктовых наборов (156-ОЗ)']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Ежегодная денежная компенсация расходов на текущий ремонт транспортного средства и горюче-смазочные материалы']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Ежегодная денежная выплата за пользование услугами связи для целей кабельного и (или) эфирного телевизионного вещания ( 5 руб. в мес.)']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Ежегодная  денежная выплата за услугу по предоставлению проводного радиовещания (8,33 руб. в мес.)']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Замена предоставления в пользование инвалидам транспортного средства при наличии соответствующих медицинских показаний и отсутствии противопоказаний к его вождению ежемесячной денежной компенсацией в размере 100 рублей']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Ежемесячная денежная выплата многодетным семьям']);
        SFRPaymentCategory::create(['pay_number' => '4', 'name' => 'Едв региональным льготникам']);
    }
}
