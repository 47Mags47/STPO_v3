<?php

namespace Database\Factories\Base;

use App\Models\Base\FileStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'disk' => config('filesystems.default'),
            'path' => '',
            'name' => Str::random(40) . '.txt',
            'origin_name' => Str::random(40),
            'status_id' => FileStatus::byCode('ok')->id,
        ];
    }
}
