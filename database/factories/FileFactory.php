<?php

namespace Database\Factories;

use App\Models\File;
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
            'name' => Str::random(40),
            'origin_name' => 'test_' . Str::random(10),
            'errors' => rand(0, 5)
                ? []
                : ['Файл содержит ошибки (тестовое сообщение)'],
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
