<?php

namespace App\Classes;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Writer
{
    public ?array $data = null;
    public ?string $fileName = null;
    public ?string $filePath = null;
    public ?string $fileDisk = null;

    public function __construct(?array $data = [])
    {
        $this->data = $data;
    }

    public function generateFileName(): string
    {
        return $this->fileName ?? Str::random(40);
    }

    public function generateFilePath(): string
    {
        return $this->filePath ?? '';
    }

    public function generateContent(): string
    {
        return '';
    }

    public function write(): bool
    {
        return Storage::disk($this->fileDisk ?? config('filesystems.default'))->put($this->generateLocalPath(), $this->generateContent());
    }

    public function generateLocalPath(): string
    {
        return $this->generateFilePath() !== ''
            ? $this->generateFilePath() . DIRECTORY_SEPARATOR . $this->generateFileName()
            : $this->generateFileName();
    }
}
