<?php

namespace App\Classes;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileWriter
{
    protected ?string $fileName = null;
    protected ?string $filePath = null;
    protected ?string $fileDisk = null;
    protected ?string $content = null;

    protected string $encoding = 'UTF-8';

    public function __construct()
    {
        if($this->fileName === null)
            $this->fileName = $this->fileName();

        if($this->filePath === null)
            $this->filePath = $this->filePath();

        if($this->fileDisk === null)
            $this->fileDisk = $this->fileDisk();

        if($this->content === null)
            $this->content = $this->content();
    }

    public function __get(string|callable $attribute)
    {
        if($attribute !== null and property_exists($this, $attribute))
            return $this->$attribute;

        if (method_exists($this, $attribute))
            return $this->$attribute();

        throw new \Exception( $this::class .' has not attribute "' . $attribute . '"');
    }

    protected function fileName(){
        return Str::random(40);
    }

    protected function fileDisk(){
        return config('filesystems.default');
    }

    protected function filePath(){
        return '';
    }

    protected function content(){
        return '';
    }

    public function write(): bool
    {
        return Storage::disk($this->fileDisk)->put($this->generateLocalPath(), $this->content);
    }

    public function generateLocalPath(): string
    {
        return $this->filePath !== ''
            ? $this->filePath . DIRECTORY_SEPARATOR . $this->fileName
            : $this->fileName;
    }
}
