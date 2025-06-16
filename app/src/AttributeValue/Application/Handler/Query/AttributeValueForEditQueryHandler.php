<?php

declare(strict_types=1);

namespace App\AttributeValue\Application\Handler\Query;

use App\AttributeValue\Application\Assembler\AttributeValueAssembler;
use App\AttributeValue\Application\Query\GetAttributeValueForEditQuery;
use App\AttributeValue\Domain\Repository\AttributeValueRepositoryInterface;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class AttributeValueForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AttributeValueRepositoryInterface $repository,
        private AttributeValueAssembler $assembler,
    ) {
    }

    public function __invoke(GetAttributeValueForEditQuery $query): array
    {
        /** @var ?AttributeValue $attributeValue */
        $attributeValue = $this->repository->findById($query->attributeValueId);
        if (null === $attributeValue) {
            throw EntityNotFoundException::for(AttributeValue::class, $query->attributeValueId);
        }

        return $this->assembler->toFormDataResponse($attributeValue);
    }
}
