<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\User;

use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteUserUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(int|string $entityId): void
    {
        $user = $this->repository->findById($entityId);
        if (null === $user) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($user);
    }
}
