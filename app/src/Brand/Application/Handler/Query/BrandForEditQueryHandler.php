<?php

declare(strict_types=1);

namespace App\Brand\Application\Handler\Query;

use App\Brand\Application\Assembler\BrandAssembler;
use App\Brand\Application\Query\GetBrandForEditQuery;
use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\Brand;
use App\Common\Domain\Exception\EntityNotFoundException;


final readonly class BrandForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private BrandRepositoryInterface $repository,
        private BrandAssembler $assembler,
    ) {}

    public function __invoke(GetBrandForEditQuery $query): array
    {
        /** @var ?Brand $brand */
        $brand = $this->repository->findById($query->brandId);
        if (null === $brand) {
            throw EntityNotFoundException::for(Brand::class, $query->brandId);
        }

        return $this->assembler->toFormDataResponse($brand);
    }
}
