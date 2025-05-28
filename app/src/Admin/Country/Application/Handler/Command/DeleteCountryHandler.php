<?php

declare(strict_types=1);

namespace App\Admin\Country\Application\Handler\Command;

use App\Admin\Country\Application\Command\DeleteCountryCommand;
use App\Admin\Country\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeleteCountryHandler implements CommandHandlerInterface
{
    public function __construct(
        private CountryRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteCountryCommand $command): void
    {
        $this->repository->remove($command->country);
    }
}
