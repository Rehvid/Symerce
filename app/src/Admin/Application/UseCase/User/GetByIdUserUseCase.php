<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\User;

use App\Admin\Application\Assembler\UserAssembler;
use App\Admin\Domain\Entity\User;
use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdUserUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserAssembler $assembler
    ) {
    }

    public function execute(int|string $entityId): array
    {
        /** @var ?User $user */
        $user = $this->repository->findById($entityId);
        if (null === $user) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($user);
    }
}
