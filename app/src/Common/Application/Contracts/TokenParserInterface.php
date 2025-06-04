<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

interface TokenParserInterface
{
    public function parse(string $token): array;
}
