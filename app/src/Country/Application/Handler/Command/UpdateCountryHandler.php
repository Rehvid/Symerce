<?php

declare (strict_types = 1);

namespace App\Country\Application\Handler\Command;

use App\Country\Application\Command\UpdateCountryCommand;
use App\Country\Application\Hydrator\CountryHydrator;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class UpdateCountryHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository,
        private CountryHydrator $hydrator
    ) {}

    public function __invoke(UpdateCountryCommand $command): IdResponse
    {
        $country = $this->hydrator->hydrate($command->countryData, $command->country);

        $this->repository->save($country);

        return new IdResponse($country->getId());
    }
}
