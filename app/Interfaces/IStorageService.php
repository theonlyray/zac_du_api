<?php

namespace App\Interfaces;

use Illuminate\Http\UploadedFile;

interface IStorageService
{
    /**
     * Upload a document or image and return an array with the url, path and extension.
     * Valid extensions are: jpg, jpeg, png, gif, dwg, pdf.
     *
     * @param UploadedFile $file
     * @param string $path
     * @param ?string $filename
     *
     * @return array ['url' => string, 'path' => string, 'extension' => string]
     */
    public function uploadFile(UploadedFile $file, string $path, ?string $filename);

    /**
     * Upload a base64 document or image and return an array with the url, path and extension.
     * Valid extensions are: jpg, jpeg, png, gif, dwg, pdf.
     *
     * @param string $base64
     * @param string $path
     * @param string $filename
     *
     * @return array ['url' => string, 'path' => string, 'extension' => string]
     */
    public function uploadBase64File(string $base64, string $path, string $filename);

    /**
     * Rename a file
     *
     * @param string $path
     * @param string $newFilename
     *
     * @return array ['url' => string, 'path' => string, 'extension' => string]
     */
    public function renameFile(string $path, string $newFilename);

    /**
     * Delete a directory and its content
     *
     * @param string $dirPath
     */
    public function deleteDirectory(string $dirPath);

    /**
     * Delete a group of files or a single file using path
     *
     * @param array $paths
     *
     * @return bool
     */
    public function deleteFiles(array $paths);
}
