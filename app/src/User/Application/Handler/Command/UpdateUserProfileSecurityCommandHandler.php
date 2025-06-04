<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\Common\Domain\Entity\User;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Application\Command\UpdateUserProfileSecurityCommand;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UpdateUserProfileSecurityCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(UpdateUserProfileSecurityCommand $command): void
    {
        /** @var ?User $user */
        $user = $this->repository->findById($command->userId);
        if (null === $user) {
            throw EntityNotFoundException::for(User::class, $command->userId);
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $command->newPassword));

        $this->repository->save($user);
    }
}
