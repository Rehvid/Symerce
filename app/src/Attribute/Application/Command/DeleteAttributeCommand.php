<?php

declare(strict_types=1);

namespace App\Attribute\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteAttributeCommand implements CommandInterface
{
    public function __construct(
        public int $attributeId,
    ) {
    }
}
