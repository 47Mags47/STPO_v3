<?php

namespace Database\Seeders\Local\Base;

use App\Models\Base\Config;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        Config::create(['key' => 'payments.division.long_name',     'value' => $faker->company()]);
        Config::create(['key' => 'payments.division.short_name',    'value' => $faker->company()]);
        Config::create(['key' => 'payments.division.INN',           'value' => $faker->numerify('##########')]);
        Config::create(['key' => 'payments.division.account',       'value' => $faker->numerify('####################')]);
        Config::create(['key' => 'payments.division.BIK',           'value' => $faker->numerify('#########')]);
        Config::create(['key' => 'payments.responsible.full_name',  'value' => $faker->lastName() . strtoupper($faker->lastName()[0]) . ' .' . strtoupper($faker->lastName()[0]) . '.']);
        Config::create(['key' => 'payments.responsible.phone',      'value' => $faker->numerify('+7 (####) ##-##-##')]);
    }
}
