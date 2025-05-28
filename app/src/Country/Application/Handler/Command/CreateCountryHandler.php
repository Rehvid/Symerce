<?php

namespace App\Country\Application\Handler\Command;

use App\Admin\Domain\Entity\Country;
use App\Country\Application\Command\CreateCountryCommand;
use App\Country\Application\Hydrator\CountryHydrator;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class CreateCountryHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository,
        private CountryHydrator $hydrator,
    ) {}

    public function __invoke(CreateCountryCommand $command): IdResponse
    {
        $country = $this->hydrator->hydrate($command->countryData, new Country());

        $this->repository->save($country);

        return new IdResponse($country->getId());
    }
}
