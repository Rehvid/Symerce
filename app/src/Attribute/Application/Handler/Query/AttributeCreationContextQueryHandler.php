<?php

declare(strict_types=1);

namespace App\Attribute\Application\Handler\Query;

use App\Attribute\Application\Assembler\AttributeAssembler;
use App\Attribute\Application\Query\GetAttributeCreationContextQuery;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class AttributeCreationContextQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AttributeAssembler $assembler
    ) {}

    public function __invoke(GetAttributeCreationContextQuery $query): array
    {
        return $this->assembler->toFormContextResponse();
    }
}
