<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Base\UploadStartUploadRequest;
use App\Http\Requests\Base\UploadWriteChunkRequest;
use App\Models\Base\FileChunk;
use App\Models\Base\UploadFile;

class UploadController extends Controller
{
    public function startUpload(UploadStartUploadRequest $request)
    {
        $uploadFile = UploadFile::create([
            'totalChunks' => (int) ceil((int) $request->input('file_size') / return_bytes(config('filesystems.max_file_size')))
        ]);

        foreach (range(1, $uploadFile->totalChunks) as $i) {
            FileChunk::create([
                'total_file_id' => $uploadFile->id,
                'npp' => $i,
            ]);
        }

        return $uploadFile->toResource();
    }

    public function writeChunk(UploadWriteChunkRequest $request, UploadFile $file, FileChunk $chunk)
    {
        $chunk->setContent($request->file('file')->getContent());
        $chunk->update(['uploaded' => true]);

        if ($file->chunks()->where('uploaded', true)->count() == $file->totalChunks) {
            $uploadFile = fopen($file->getFullPath(), "wb");

            $file->chunks()->orderBy('npp')->get()->each(function ($chunk) use ($uploadFile) {
                $chunkFile = fopen($chunk->getFullPath(), "rb");
                stream_copy_to_stream($chunkFile, $uploadFile);
                fclose($chunkFile);

                $chunk->delete();
            });

            fclose($uploadFile);
        }

        return response()->json();
    }
}
