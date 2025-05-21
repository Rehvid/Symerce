<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response;

/** @deprecated  */
interface ResponseInterfaceData
{
    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self;
}
