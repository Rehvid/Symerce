<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Application\Command\DeleteUserCommand;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->repository->remove($command->user);
    }
}
