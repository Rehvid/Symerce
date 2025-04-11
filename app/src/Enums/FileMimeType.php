<?php

declare(strict_types=1);

namespace App\Enums;

enum FileMimeType: string
{
    case JPEG = 'image/jpeg';
    case PNG = 'image/png';
    case WEBP = 'image/webp';

    case PDF = 'application/pdf';
}
