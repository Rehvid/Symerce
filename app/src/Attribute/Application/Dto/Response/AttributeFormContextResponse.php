<?php

declare(strict_types=1);

namespace App\Attribute\Application\Dto\Response;

final readonly class AttributeFormContextResponse
{
    public function __construct(
        public array $availableTypes
    ) {}
}
