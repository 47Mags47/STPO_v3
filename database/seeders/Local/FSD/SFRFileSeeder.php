<?php

namespace Database\Seeders\Local\FSD;

use App\Models\FSD\SFRFile;
use Illuminate\Database\Seeder;

class SFRFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SFRFile::factory(10)->create();
    }
}
