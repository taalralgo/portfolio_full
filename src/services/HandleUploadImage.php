<?php

declare(strict_types=1);

namespace App\services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class HandleUploadImage implements HandleUploadImageInterface
{

    /**
     * @var SluggerInterface
     */
    private SluggerInterface $slugger;

    /**
     * @var string
     */
    private string $uploadPath;

    /**
     * @param SluggerInterface $slugger
     * @param string $uploadPath
     */
    public function __construct(SluggerInterface $slugger, string $uploadDir)
    {
        $this->slugger = $slugger;
        $this->uploadPath = $uploadDir;
    }


    /**
     * @param UploadedFile $uploadedFile
     * @param string $uploadPath
     * @return string
     */
    public function uploadImage(UploadedFile $uploadedFile, string $uploadPath): string
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($this->uploadPath, $newFilename);
        return $newFilename;
    }

    /**
     * @param string $absoluteFilePath
     * @return bool
     */
    public function removeUploadFile(string $absoluteFilePath): bool
    {
        return unlink($absoluteFilePath);
    }
}