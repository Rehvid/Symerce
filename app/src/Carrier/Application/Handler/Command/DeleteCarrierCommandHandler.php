<?php

declare(strict_types = 1);

namespace App\Carrier\Application\Handler\Command;

use App\Carrier\Application\Command\DeleteCarrierCommand;
use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeleteCarrierCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CarrierRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteCarrierCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->carrierId)
        );
    }
}
