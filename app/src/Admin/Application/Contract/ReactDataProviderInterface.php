<?php

declare(strict_types=1);

namespace App\Admin\Application\Contract;

interface ReactDataProviderInterface
{
    /** @return array<int, mixed> */
    public function getData(): array;

    public function getName(): string;
}
