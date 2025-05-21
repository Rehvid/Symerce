<?php

declare(strict_types=1);

namespace App\Admin\Application\Contract;

interface TokenParserInterface
{
    public function parse(string $token): array;
}
