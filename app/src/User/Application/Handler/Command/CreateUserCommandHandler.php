<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\User;
use App\User\Application\Command\CreateUserCommand;
use App\User\Application\Hydrator\UserHydrator;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserHydrator $hydrator,
        private UserRepositoryInterface $repository
    ) {
    }

    public function __invoke(CreateUserCommand $command): IdResponse
    {
        $user = $this->hydrator->hydrate($command->data, new User());

        $this->repository->save($user);

        return new IdResponse($user->getId());
    }
}
