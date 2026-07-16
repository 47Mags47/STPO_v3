<?php

namespace Database\Seeders\Prod\SFR\FSD;

use App\Models\SFR\FSD\ASPPaymentCategory;
use App\Models\SFR\FSD\SFRPaymentCategory;
use Illuminate\Database\Seeder;

class ASPPaymentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежегодная денежная выплата за пользование услугами связи для целей кабельного и (или) эфирного телевизионного вещания ( 5 руб. в мес.)')->get()->first()->id, 'name' => 'ГДВ за услугу связи телевизионного вещания']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежегодная денежная выплата за пользование услугами связи для целей кабельного и (или) эфирного телевизионного вещания ( 5 руб. в мес.)')->get()->first()->id, 'name' => 'ЕДК инвалидам по зрению за радио']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежемесячная денежная выплата на частичную оплату жилого помещения и коммунальных услуг отдельным категориям граждан (15-ОЗ)')->get()->first()->id, 'name' => 'ЕДВ на частичную оплату ЖКУ отдельным категориям г']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежемесячная денежная выплата на частичную оплату жилого помещения и коммунальных услуг отдельным категориям граждан (15-ОЗ)')->get()->first()->id, 'name' => 'ЕДВ на частичную оплату ЖКХ']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежегодная  денежная выплата за услугу по предоставлению проводного радиовещания (8,33 руб. в мес.)')->get()->first()->id, 'name' => 'ГДВ за услугу проводного радиовещания']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'ЕДВ по оплате услуги телефонов связи')->get()->first()->id, 'name' => 'ЕДВ абонентам сети фиксиров.телефон.связи']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Денежная выплата отдельным категориям граждан взамен получения ими продуктовых наборов (156-ОЗ)')->get()->first()->id, 'name' => 'КДВ отд. кат.граждан взамен проднаборов']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежегодная денежная компенсация расходов на текущий ремонт транспортного средства и горюче-смазочные материалы')->get()->first()->id, 'name' => 'ГДК на текущий ремонт ТС и ГСМ (несчастный случай ']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежегодная денежная компенсация расходов на текущий ремонт транспортного средства и горюче-смазочные материалы')->get()->first()->id, 'name' => 'Компенсация расходов на текущий ремонт ТС и ГСМ']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежемесячная денежная выплата многодетным семьям')->get()->first()->id, 'name' => 'Ежемесячная выплата многодетным 1000 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежемесячная денежная выплата многодетным семьям')->get()->first()->id, 'name' => 'Ежемесячная выплата многодетным 1200 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Ежемесячная денежная выплата многодетным семьям')->get()->first()->id, 'name' => 'Ежемесячная денежная выплата в размере 1200 рублей']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => 'компенсация по оплате ЖКУ (решение суда)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация оплаты за газоснабжение в баллонах']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => 'Компенсация по капремонту (100%)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => 'Компенсация по капремонту (50%)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => 'Компенсация по капремонту 100%']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => 'Компенсация по капремонту 50%']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => 'Снижение оплаты за электроснабжение(7квт/ч на 1к.м']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате ОДН ГВ']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате ОДН ХВ']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате ОДН Эл.']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплату отвед. сточных вод на ОД']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате тверд.топлива не > 5 т.']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате твердого топлива']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате за кап ремонт жилья рег']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате за кап ремонт жилья фед']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате за соц.найм']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация оплаты за газоснабжение в баллонах']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация на оплату ЭлЭн на ОДН (жил.услуги']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация на оплату отвед.сточных вод на ОД']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация на оплату ХВС на ОДН (жил.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате ТКО']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате водоотведения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате горячего водоснабдения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по доставке  твердого топлива']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате твердого топлива']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация на оплату ГВС на ОДН (жил.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация на оплату сточных вод на ОДН в МКД']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация на оплату ГВС на ОДН (ком.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация на оплату ХВС на ОДН (ком.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате газоснабжения в баллонах']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация оплаты за газоснабжение в баллона']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация за вывоз бытовых и других отходов']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация на оплату ГВС на ОДН (ком.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация на оплату ХВС на ОДН (ком.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация на оплату Эл.Эн. на ОДН (ком.услуг']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация за вывоз бытовых и других отходов']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате холодного водоснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате газоснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате газоснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по доставке твердого топлива']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате твердого топлива']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате холодного водоснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация на оплату ХВС на ОДН (жил.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате водоотведения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация на оплату ЭлЭн на ОДН (жил.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате электроснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате ТКО']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация на оплату ГВС на ОДН (жил.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация на оплату ЭлЭн на ОДН (жил.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате капитального ремонта']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате жилья']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате горячего водоснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате холодного водоснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация на оплату отвед.сточных вод на ОДН']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация на оплату ХВС на ОДН (жил.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация по оплате отопления']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате отопления']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате ТКО']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате капитального ремонта']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате горячего водоснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация на оплату ГВС на ОДН (жил.услуги)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате электроснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате жилья']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация по оплате водоотведения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компесация по оплате холодного водоснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация на оплату отвед.сточных вод на ОДН']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате капитального ремонта']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате жилья']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате отопления']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по оплате электроснабжения']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенс.по оплате жилья']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '50% компенсация оплаты за газоснабжение']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация оплаты за газоснабжение']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '30% компенсация на оплату Эл.Эн. на ОДН (ком.услуг']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Компенсация на оплату ЖКУ')->get()->first()->id,        'name' => '100% компенсация по доставке твердого топлива']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'ПКО ветеранам боевых действий(ст11 № 8-ОЗ 14.01.19']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-2000 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-900рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-850 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-героям Кузбасса']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'ПКО почетным гражданам Кузбасса']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-1000 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса - за 50 л. стаж в учрежд.культуры ']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-800 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-3000рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-750рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-770 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса- почетному гражданину КО']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия ПКузбасса-за особый вклад в развитие Кузбас']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-за особый вклад в развитие Кузбасс']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-900 рублей (2)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-950 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-2150 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-1050 рублей(1)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-1050 рублей (2)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-920 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-1150 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса-900 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-650 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия ПКО-за особый вклад в развитие Кузбасса (м.']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО- почетному гражданину КО']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-героям Кузбасса']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'ПКО гражданам, удостоенным звания Героя Кузбасса (']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'ПКО медработникам (стаж 50 и более лет) (п3-1 ст13']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'ПКО гр.,один из родит. которых погиб в боевых дейс']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'ПКО за особый вклад в развитие Кузбасса(п3 ст9 № 8']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'ПКО педагогам общеораз. орган. (стаж 50 и более ле']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'ПКО Почетн. энергетикам,металлург., химикам, шахте']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-1000 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО - за 50 л. стаж в учрежд.культуры Кем.об']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-3000рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-770 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-800 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-750рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-2000 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО-900 рублей (2)']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия КО - 10000 рублей']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса члену семьи погиб(ум) сотрудн. ОВД']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Пенсия Кемеровской области')->get()->first()->id,       'name' => 'Пенсия Кузбасса члену семьи гр-на, посмертно удост']);

        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Едв региональным льготникам')->get()->first()->id,      'name' => 'ЕДВ ветеранам труда']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Едв региональным льготникам')->get()->first()->id,      'name' => 'ЕДВ труженникам тыла']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Едв региональным льготникам')->get()->first()->id,      'name' => 'ЕДВ труженикам тыла']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Едв региональным льготникам')->get()->first()->id,      'name' => 'ЕДВ реабилитированным лицам']);
        ASPPaymentCategory::create(['sfr_payment_category_id' => SFRPaymentCategory::where('name', 'Едв региональным льготникам')->get()->first()->id,      'name' => 'ЕДВ лицам,пострадавшим от полит.репрессий']);
    }
}
