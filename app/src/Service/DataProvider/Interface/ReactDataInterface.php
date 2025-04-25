<?php

declare(strict_types=1);

namespace App\Service\DataProvider\Interface;

interface ReactDataInterface
{
    public function getData(): array;
    public function getName(): string;
}
