<?php

declare(strict_types=1);

namespace App\Brand\Application\Handler\Command;

use App\Brand\Application\Command\CreateBrandCommand;
use App\Brand\Application\Hydrator\BrandHydrator;
use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class CreateBrandCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private BrandHydrator $hydrator,
        private BrandRepositoryInterface $repository
    ) {}

    public function __invoke(CreateBrandCommand $command): IdResponse
    {
        $brand = $this->hydrator->hydrate($command->data);

        $this->repository->save($brand);


        return new IdResponse($brand->getId());
    }
}
