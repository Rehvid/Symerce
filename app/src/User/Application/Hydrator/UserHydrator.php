<?php

declare(strict_types=1);

namespace App\User\Application\Hydrator;

use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\User;
use App\User\Application\Dto\UserData;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserHydrator
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private FileService $fileService,
    ) {
    }

    public function hydrate(UserData $data, User $user): User
    {
        if (null !== $data->password) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $data->password));
        }

        $user->setEmail($data->email);
        $user->setFirstname($data->firstname);
        $user->setSurname($data->surname);
        $user->setRoles($data->roles);
        $user->setIsActive($data->isActive);

        if ($data->avatar) {
            $this->fileService->replaceFile($user, $data->avatar);
        }

        return $user;
    }
}
