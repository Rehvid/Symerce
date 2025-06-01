<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\Admin\Domain\Entity\User;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\User\Application\Command\CreateUserCommand;
use App\User\Application\Hydrator\UserHydrator;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserHydrator $hydrator,
        private UserRepositoryInterface $repository
    ) {}


    public function __invoke(CreateUserCommand $command): IdResponse
    {
        $user = $this->hydrator->hydrate($command->data);

        $this->repository->save($user);

        return new IdResponse($user->getId());
    }
}
