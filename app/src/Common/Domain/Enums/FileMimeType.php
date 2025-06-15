<?php

declare(strict_types=1);

namespace App\Common\Domain\Enums;

use App\Common\Domain\Traits\EnumValuesTrait;

enum FileMimeType: string
{
    use EnumValuesTrait;

    case JPEG = 'image/jpeg';
    case PNG = 'image/png';
    case WEBP = 'image/webp';

    case PDF = 'application/pdf';
}
