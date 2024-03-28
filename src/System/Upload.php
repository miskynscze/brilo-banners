<?php

namespace App\System;

use Symfony\Component\String\Slugger\SluggerInterface;

class Upload
{

    public function __construct(protected SluggerInterface $slugger) {}

    public function uploadFile(mixed $data, string $directory): string
    {
        $bannerName = pathinfo($data->getClientOriginalName(), PATHINFO_FILENAME);

        $curedName = $this->slugger->slug($bannerName);
        $newBannerName = $curedName . '-' . uniqid() . '-' . $data->guessExtension();

        $data->move(
            $directory,
            $newBannerName
        );

        return $newBannerName;
    }

    public function removeFile(string $filePath): void
    {
        if(file_exists($filePath)) {
            unlink($filePath);
        }
    }
}