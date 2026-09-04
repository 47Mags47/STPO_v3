<?php

namespace Database\Seeders\Local\Payment;

use App\Models\Payment\PaymentFile;
use App\Models\Payment\Recipient;
use Illuminate\Database\Seeder;

class RecipientSeeder extends Seeder
{
    public function run(): void
    {
        PaymentFile::get('id')->each(function ($file) {
            Recipient::factory(5)->create([
                'file_id' => $file->id,
            ]);
        });
    }
}
