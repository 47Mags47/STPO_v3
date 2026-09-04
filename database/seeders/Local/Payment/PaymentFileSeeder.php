<?php

namespace Database\Seeders\Local\Payment;

use App\Models\Administrate\Bank;
use App\Models\Administrate\Template;
use App\Models\Payment\BankContract;
use App\Models\Payment\Event;
use App\Models\Payment\PaymentFile;
use Illuminate\Database\Seeder;

class PaymentFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $template_ids = Template::whereLike('description', 'Файл выгрузки выплаты%')->get('id')->pluck('id');
        $bank_ids = BankContract::whereIn('template_id', $template_ids)->get('bank_id')->pluck('bank_id');
        $banks = Bank::whereIn('id', $bank_ids)->get();

        $banks->each(function ($bank) {
            Event::all()->each(function ($event) use ($bank) {
                PaymentFile::factory(3)->create([
                    'event_id' => $event->id,
                    'bank_id' => $bank->id
                ]);
            });
        });
    }
}
