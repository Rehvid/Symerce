<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\User;

use App\Admin\Application\Hydrator\UserHydrator;
use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Entity\User;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateUserUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private UserHydrator $hydrator,
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        /** @var ?User $user */
        $user = $this->repository->findById($entityId);
        if (null === $user) {
            throw new EntityNotFoundException();
        }

        $this->hydrator->hydrate($requestDto, $user);

        $this->repository->save($user);

        return (new IdResponse($user->getId()))->toArray();
    }
}
