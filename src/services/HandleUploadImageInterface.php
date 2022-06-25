<?php

declare(strict_types=1);

namespace App\services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface HandleUploadImageInterface
{
    public function uploadImage(UploadedFile $uploadedFile, string $uploadPath): string;
}