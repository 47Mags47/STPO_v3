<?php

namespace Database\Seeders\Local\FSD;

use App\Models\FSD\Recipient;
use App\Models\FSD\SFRFile;
use Illuminate\Database\Seeder;

class RecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SFRFile::all()->each(fn($file) => Recipient::factory(10)->create(['file_id' => $file->id]));
    }
}
