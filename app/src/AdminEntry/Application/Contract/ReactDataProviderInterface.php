<?php

declare(strict_types=1);

namespace App\AdminEntry\Application\Contract;

interface ReactDataProviderInterface
{
    /** @return array<mixed, mixed> */
    public function getData(): array;

    public function getName(): string;
}
