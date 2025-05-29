<?php

declare(strict_types=1);

namespace App\Currency\Application\Handler\Command;

use App\Currency\Application\Command\DeleteCurrencyCommand;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

final readonly class DeleteCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $repository,
    ) {}

    public function __invoke(DeleteCurrencyCommand $command): void
    {
        $this->repository->remove($command->currency);
    }
}
