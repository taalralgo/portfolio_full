<?php

declare(strict_types=1);

namespace App\services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface HandleUploadImageInterface
{
    /**
     * Upload an image
     *
     * @author Daouda S. THERA <ddthera@gmail.com>
     * @param UploadedFile $uploadedFile
     * @param string $uploadPath
     * @return string
     */
    public function uploadImage(UploadedFile $uploadedFile, string $uploadPath): string;

    /**
     * Delete image from uploads directory
     *
     * @author Daouda S. THERA <ddthera@gmail.com>
     * @param string $absoluteFilePath
     * @return bool
     */
    public function removeUploadFile(string $absoluteFilePath): bool;
}