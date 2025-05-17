<?php

declare(strict_types=1);

namespace App\Shared\Application\UseCases\Base;

interface GetByIdUseCaseInterface
{
    public function execute(string|int $entityId): mixed;
}
