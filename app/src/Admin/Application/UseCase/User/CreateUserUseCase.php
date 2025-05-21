<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\User;

use App\Admin\Application\Hydrator\UserHydrator;
use App\Admin\Domain\Entity\User;
use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateUserUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private UserHydrator $hydrator,
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(RequestDtoInterface $requestDto): array
    {
        $user = new User();

        $this->hydrator->hydrate($requestDto, $user);

        $this->repository->save($user);

        return (new IdResponse($user->getId()))->toArray();
    }
}
