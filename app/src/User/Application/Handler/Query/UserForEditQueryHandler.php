<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\User;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\User\Application\Assembler\UserAssembler;
use App\User\Application\Query\GetUserForEditQuery;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class UserForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserAssembler $assembler,
        private UserRepositoryInterface $repository
    ){}

    public function __invoke(GetUserForEditQuery $query): array
    {
        /** @var ?User $user */
        $user = $this->repository->findById($query->userId);
        if (null === $user) {
            throw EntityNotFoundException::for(User::class, $query->userId);
        }

        return $this->assembler->toFormDataResponse($user);
    }
}
