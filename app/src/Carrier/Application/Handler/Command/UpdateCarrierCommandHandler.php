<?php

declare(strict_types=1);

namespace App\Carrier\Application\Handler\Command;

use App\Carrier\Application\Command\UpdateCarrierCommand;
use App\Carrier\Application\Hydrator\CarrierHydrator;
use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Carrier;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class UpdateCarrierCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        public CarrierRepositoryInterface $repository,
        public CarrierHydrator $hydrator,
    ){}

    public function __invoke(UpdateCarrierCommand $command): IdResponse
    {
        /** @var ?Carrier $carrier */
        $carrier = $this->repository->findById($command->carrierId);
        if (null === $carrier) {
            throw EntityNotFoundException::for(Carrier::class, $command->carrierId);
        }

        $carrier = $this->hydrator->hydrate($command->data, $carrier);

        $this->repository->save($carrier);

        return new IdResponse($carrier->getId());
    }
}
