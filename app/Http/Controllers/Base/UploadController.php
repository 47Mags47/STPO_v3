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

        for ($i = 1; $i <= $uploadFile->totalChunks; $i++) {
            FileChunk::create([
                'upload_file_id' => $uploadFile->id,
                'npp' => $i,
            ]);
        }

        return $uploadFile->toResource();
    }

    public function writeChunk(UploadWriteChunkRequest $request, FileChunk $chunk)
    {
        $chunk->setContent($request->file('file')->getContent());
        $chunk->update(['uploaded' => true]);

        // Сборка файла
        $uploadFile = $chunk->uploadFile;
        if ($uploadFile->chunks()->where('uploaded', true)->count() == $uploadFile->totalChunks) {
            $uploadFileResource = fopen($uploadFile->getFullPath(), "wb");

            $uploadFile->chunks()->orderBy('npp')->get()->each(function ($chunk) use ($uploadFileResource) {
                $chunkFileResource = fopen($chunk->getFullPath(), "rb");
                stream_copy_to_stream($chunkFileResource, $uploadFileResource);
                fclose($chunkFileResource);

                $chunk->delete();
            });

            fclose($uploadFileResource);
        }

        return response()->json();
    }
}
