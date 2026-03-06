<?php

namespace Database\Seeders\Local\FSD;

use App\Models\FSD\Payment;
use App\Models\FSD\PaymentFile;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentFile::all()->each(fn($file) => Payment::factory(10)->create(['file_id' => $file->id]));
    }
}
