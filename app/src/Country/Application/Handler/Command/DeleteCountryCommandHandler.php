<?php

declare(strict_types=1);

namespace App\Country\Application\Handler\Command;


use App\Country\Application\Command\DeleteCountryCommand;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeleteCountryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteCountryCommand $command): void
    {
        $this->repository->remove(
            $this->repository->findById($command->countryId)
        );
    }
}
