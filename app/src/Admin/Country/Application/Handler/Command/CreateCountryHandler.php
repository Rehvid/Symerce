<?php

namespace App\Admin\Country\Application\Handler\Command;

use App\Admin\Country\Application\Command\CreateCountryCommand;
use App\Admin\Country\Application\Hydrator\CountryHydrator;
use App\Admin\Country\Domain\Repository\CountryRepositoryInterface;
use App\Admin\Domain\Entity\Country;
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
