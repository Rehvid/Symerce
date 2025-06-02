<?php

declare(strict_types=1);

namespace App\Attribute\Application\Command;

use App\Shared\Application\Command\CommandInterface;

final readonly class DeleteAttributeCommand implements CommandInterface
{
    public function __construct(
        public int $attributeId,
    ) {}
}
