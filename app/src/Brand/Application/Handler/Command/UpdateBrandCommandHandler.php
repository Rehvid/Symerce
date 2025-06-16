<?php

declare(strict_types=1);

namespace App\Brand\Application\Handler\Command;

use App\Brand\Application\Command\UpdateBrandCommand;
use App\Brand\Application\Hydrator\BrandHydrator;
use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Brand;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class UpdateBrandCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private BrandRepositoryInterface $repository,
        private BrandHydrator $hydrator,
    ) {
    }

    public function __invoke(UpdateBrandCommand $command): IdResponse
    {
        /** @var ?Brand $brand */
        $brand = $this->repository->findById($command->brandId);
        if (null === $brand) {
            throw EntityNotFoundException::for(Brand::class, $command->brandId);
        }

        $brand = $this->hydrator->hydrate($command->data, $brand);

        $this->repository->save($brand);

        return new IdResponse($brand->getId());
    }
}
