<?php

declare (strict_types = 1);

namespace App\Country\Application\Handler\Command;

use App\Admin\Domain\Entity\Country;
use App\Country\Application\Command\UpdateCountryCommand;
use App\Country\Application\Hydrator\CountryHydrator;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Domain\Exception\EntityNotFoundException;

final readonly class UpdateCountryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository,
        private CountryHydrator $hydrator
    ) {}

    public function __invoke(UpdateCountryCommand $command): IdResponse
    {
        /** @var ?Country $country */
        $country = $this->repository->findById($command->countryId);
        if (null === $country) {
            throw EntityNotFoundException::for(Country::class, $command->countryId);
        }

        $country = $this->hydrator->hydrate($command->data, $country);

        $this->repository->save($country);

        return new IdResponse($country->getId());
    }
}
