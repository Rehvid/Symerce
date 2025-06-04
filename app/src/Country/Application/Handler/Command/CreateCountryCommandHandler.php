<?php

namespace App\Country\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Country\Application\Command\CreateCountryCommand;
use App\Country\Application\Hydrator\CountryHydrator;
use App\Country\Domain\Repository\CountryRepositoryInterface;

final readonly class CreateCountryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository,
        private CountryHydrator $hydrator,
    ) {}

    public function __invoke(CreateCountryCommand $command): IdResponse
    {
        $country = $this->hydrator->hydrate($command->data);

        $this->repository->save($country);

        return new IdResponse($country->getId());
    }
}
