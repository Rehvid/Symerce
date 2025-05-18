<?php

declare(strict_types=1);

namespace App\Shared\Application\UseCases\Base;

interface QueryUseCaseInterface
{
    public function execute(): mixed;
}
