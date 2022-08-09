<?php

namespace App\Services;

use App\Interfaces\IStorageService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageService implements IStorageService
{
    protected $validExtensions =  [
        'jpg', 'jpeg', 'png', 'pdf', #'dwg',
    ];

    public function uploadFile(UploadedFile $file, string $path, ?string $filename)
    {
        $relativePath = '';
        $extension = Str::lower($file->getClientOriginalExtension());

        if (collect($this->validExtensions)->contains($extension)) {

            if ($filename) {
                $sanitizedFilename = str_replace(" ", "_", $filename) . '_' . time();
                $relativePath = Storage::putFileAs($path, $file, $sanitizedFilename . '.' . $extension, 'public');
            } else {
                $relativePath = Storage::putFile($path, $file, 'public');
            }

            return [
                "url" => Storage::url($relativePath),
                "path" => $relativePath,
                "extension" => $extension,
            ];
        }

        throw new Exception("El tipo de archivo no es válido, inténtalo nuevamente.", 400);
    }

    public function uploadBase64File(string $base64, string $path, string $filename)
    {
        $decodedFile = base64_decode($base64);
        $props = getimagesizefromstring($decodedFile);
        $extension = substr(image_type_to_extension($props[2]), 1);
        $relativePath = $path . '/' . $filename . '.' . $extension;

        if (collect($this->validExtensions)->contains($extension)) {
            $saved = Storage::put($relativePath, $decodedFile, 'public');
            return [
                "url" => Storage::url($relativePath),
                "path" => $relativePath,
                "extension" => $extension,
                "save" => $saved
            ];
        }

        throw new Exception("El tipo de archivo no es válido, inténtalo nuevamente.", 400);
    }

    /**
     * Upload a documento or blueprint
     * @param string $base64
     * @param string $directoryPath
     * @param string $filename
     * @return bool
     * @throws ServerException
     */
    public function saveDocumentBlueprint(string $base64, string $path, string $filename)
    {
        $decodedFile = base64_decode($base64);
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        // $validExtensions = ['dwg', 'pdf'];  . '.' . $extension
        $relativePath = $path . '/' . $filename;

        // if (!in_array($extension, $validExtensions)) abort(400, 'El tipo de archivo no es admitido.');
        if (collect($this->validExtensions)->contains($extension)) {
            Storage::put($relativePath, $decodedFile, 'public');
            return [
                "url" => Storage::url($relativePath),
                "path" => $relativePath,
                "extension" => $extension,
            ];
        }
        throw new Exception("El tipo de archivo no es válido, inténtalo nuevamente.", 400);
    }

    public function renameFile(string $path, string $newFilename)
    {
        $pathWithoutFilename = Str::beforeLast($path, '/');
        $extension = Str::afterLast($path, '.');
        $newPath = $pathWithoutFilename . '/' . str_replace(" ", "_", $newFilename) . '_' . time() . '.' . $extension;

        Storage::move($path, $newPath);

        return [
            'url' => Storage::url($newPath),
            'path' => $newPath,
            'extension' => $extension,
        ];
    }

    public function deleteDirectory(string $dirPath)
    {
        return Storage::deleteDirectory($dirPath);
    }

    public function deleteFiles(array $paths)
    {
        try {
            return Storage::delete($paths);
        } catch (\Throwable $th) {
            return false;
        }
    }
}
