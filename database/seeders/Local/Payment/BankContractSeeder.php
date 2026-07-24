<?php

namespace Database\Seeders\Local\Payment;

use App\Models\Administrate\Bank;
use App\Models\Base\File;
use App\Models\Base\Template;
use App\Models\Payment\BankContract;
use Illuminate\Database\Seeder;

class BankContractSeeder extends Seeder
{
    public function run(): void
    {
        BankContract::factory()->create([
            'bank_id' => Bank::factory()->create([
                'code'  => 'test_Sber',
                'name'  => 'Сбербанк (тест)'
            ])->id,
            'template_id' => Template::whereKey(File::where('origin_name', 'RaportToBank_Sber.blade.php')->get()->first()->id)->first()->id,
        ]);

        BankContract::factory()->create([
            'bank_id' => Bank::factory()->create([
                'code'  => 'test_Rosselhoz',
                'name'  => 'Россельхоз (тест)'
            ])->id,
            'template_id' => Template::whereKey(File::where('origin_name', 'RaportToBank_UralSib.blade.php')->get()->first()->id)->first()->id,
        ]);
    }
}
