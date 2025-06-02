<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Command;

use App\Shared\Application\Command\CommandInterface;

final readonly class DeleteAttributeValueCommand implements CommandInterface
{
    public function __construct(
        public int $attributeValueId,
    ) {}
}
