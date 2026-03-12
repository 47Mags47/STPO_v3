<?php

namespace Database\Seeders\Local\FSD;

use App\Models\FSD\PaymentFile;
use App\Models\FSD\SFRFile;
use Illuminate\Database\Seeder;

class PaymentFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SFRFile::all()->each(fn($file)=> PaymentFile::factory(10)->create([
            'sfr_file_id' => $file->id,
        ]));
    }
}
