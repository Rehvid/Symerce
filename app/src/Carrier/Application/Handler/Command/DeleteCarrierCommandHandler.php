<?php

declare(strict_types = 1);

namespace App\Carrier\Application\Handler\Command;

use App\Carrier\Application\Command\DeleteCarrierCommand;
use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Carrier;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class DeleteCarrierCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CarrierRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteCarrierCommand $command): void
    {
        /** @var ?Carrier $carrier */
        $carrier = $this->repository->findById($command->carrierId);
        if (null === $carrier) {
            throw EntityNotFoundException::for(Carrier::class, $command->carrierId);
        }

        $this->repository->remove($carrier);
    }
}
