<?php

declare(strict_types=1);

namespace App\Carrier\Application\Handler\Command;

use App\Carrier\Application\Command\CreateCarrierCommand;
use App\Carrier\Application\Hydrator\CarrierHydrator;
use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Carrier;

final readonly class CreateCarrierCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        public CarrierRepositoryInterface $repository,
        public CarrierHydrator $hydrator,
    ) {}

    public function __invoke(CreateCarrierCommand $command): IdResponse
    {
        $carrier = $this->hydrator->hydrate($command->data, new Carrier());

        $this->repository->save($carrier);

        return new IdResponse($carrier->getId());
    }
}
