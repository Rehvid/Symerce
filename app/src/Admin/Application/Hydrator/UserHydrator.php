<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\User\SaveUseRequest;
use App\Admin\Application\Service\FileService;
use App\Admin\Domain\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserHydrator
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private FileService $fileService,
    ) {
    }

    public function hydrate(SaveUseRequest $request, User $user): User
    {
        if (null !== $request->password) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $request->password));
        }
        $user->setEmail($request->email);
        $user->setFirstname($request->firstname);
        $user->setSurname($request->surname);
        $user->setRoles($request->roles);
        $user->setIsActive($request->isActive);

        if ($request->avatar) {
            $this->fileService->replaceFile($user, $request->avatar);
        }

        return $user;
    }
}
