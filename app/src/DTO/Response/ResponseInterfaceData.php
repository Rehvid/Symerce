<?php

declare(strict_types=1);

namespace App\DTO\Response;

interface ResponseInterfaceData
{
    public static function fromArray(array $data): self;
}
