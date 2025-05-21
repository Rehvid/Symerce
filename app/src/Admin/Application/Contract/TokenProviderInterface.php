<?php

declare(strict_types=1);

namespace App\Admin\Application\Contract;

interface TokenProviderInterface
{
    public function getToken(): string;
}
