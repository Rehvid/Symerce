<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\User;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\User\Application\Command\UpdateUserCommand;
use App\User\Application\Hydrator\UserHydrator;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserHydrator $hydrator,
        private UserRepositoryInterface $repository
    ) {}

    public function __invoke(UpdateUserCommand $command): IdResponse
    {
        /** @var ?User $user */
        $user = $this->repository->findById($command->userId);
        if (null === $user) {
            throw EntityNotFoundException::for(User::class, $command->userId);
        }

        $user = $this->hydrator->hydrate($command->data, $user);

        $this->repository->save($user);

        return new IdResponse($user->getId());
    }
}
