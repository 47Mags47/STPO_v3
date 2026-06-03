<?php

namespace Database\Factories\Base;

use App\Models\Base\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
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
            'upload_at' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (File $file) {
            Storage::disk($file->disk)->put($file->path . '/' . $file->name, '');
        });
    }
}
