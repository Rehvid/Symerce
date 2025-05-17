<?php

declare(strict_types=1);

namespace App\Shared\Application\UseCases\Base;

interface DeleteUseCaseInterface
{
    public function execute(string|int $entityId): void;
}
