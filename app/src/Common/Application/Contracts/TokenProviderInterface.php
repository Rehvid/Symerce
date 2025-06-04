<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

interface TokenProviderInterface
{
    public function getToken(): string;
}
