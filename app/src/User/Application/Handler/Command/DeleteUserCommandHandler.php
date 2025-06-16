<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\User;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\User\Application\Command\DeleteUserCommand;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        /** @var ?User $user */
        $user = $this->repository->findById($command->userId);
        if (null === $user) {
            throw EntityNotFoundException::for(User::class, $command->userId);
        }

        $this->repository->remove($user);
    }
}
