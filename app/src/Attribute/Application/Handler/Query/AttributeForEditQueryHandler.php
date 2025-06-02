<?php

declare(strict_types=1);

namespace App\Attribute\Application\Handler\Query;

use App\Attribute\Application\Assembler\AttributeAssembler;
use App\Attribute\Application\Query\GetAttributeForEditQuery;
use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class AttributeForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AttributeRepositoryInterface $repository,
        private AttributeAssembler $assembler,
    ) {}

    public function __invoke(GetAttributeForEditQuery $query): array
    {
        /** @var ?Attribute $attribute */
        $attribute = $this->repository->findById($query->attributeId);
        if (null === $attribute) {
            throw EntityNotFoundException::for(Attribute::class, $query->attributeId);
        }

        return $this->assembler->toFormDataResponse($attribute);
    }
}
