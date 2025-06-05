<?php

declare(strict_types=1);

namespace App\Country\Application\Handler\Command;


use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Country;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Country\Application\Command\DeleteCountryCommand;
use App\Country\Domain\Repository\CountryRepositoryInterface;

final readonly class DeleteCountryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteCountryCommand $command): void
    {
        /** @var ?Country $country */
        $country = $this->repository->findById($command->countryId);
        if (null === $country) {
            throw EntityNotFoundException::for(Country::class, $command->countryId);
        }

        $this->repository->remove($country);
    }
}
