<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Profile;

use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UpdateSecurityUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function execute(UpdateSecurityRequest $requestDto, User $user): void
    {
        $user->setPassword($this->passwordHasher->hashPassword($user, $requestDto->password));
        $this->repository->save($user);
    }
}
