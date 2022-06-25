<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class Helper
{
    /**
     * @param Request $request
     * @return string
     * return base url
     */
    public static function getBaseUrl(Request $request): string
    {
        return $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
    }

    /**
     * @return string
     * Image location on server
     */
    public static function imagePath(): string
    {
        return "/uploads/";
    }
}