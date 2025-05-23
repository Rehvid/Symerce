<?php

declare(strict_types=1);

namespace App\Service\DataProvider\Interface;

interface ReactDataInterface
{
    /** @return array<int, mixed> */
    public function getData(): array;

    public function getName(): string;
}
