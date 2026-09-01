<?php

namespace Database\Seeders\Local\Payment;

use App\Models\Administrate\Bank;
use App\Models\Administrate\Template;
use App\Models\Payment\BankContract;
use App\Writers\Payment\ExampleWriter;
use Illuminate\Database\Seeder;

class BankContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::all()->each(fn($bank) => BankContract::factory()->create([
            'bank_id' => $bank->id,
            'template_id' => Template::where('writer', ExampleWriter::class)->get()->first()->id
        ]));
    }
}
