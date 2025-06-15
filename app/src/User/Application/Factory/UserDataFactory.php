<?php

declare (strict_types=1);

namespace App\User\Application\Factory;

use App\User\Application\Dto\Request\SaveUserRequest;
use App\User\Application\Dto\UserData;

final readonly class UserDataFactory
{
    public function fromRequest(SaveUserRequest $userRequest): UserData
    {
        $password = $userRequest->passwordRequest->password === '' ? null : $userRequest->passwordRequest->password;

        return new UserData(
            email: $userRequest->email,
            firstname: $userRequest->firstname,
            surname: $userRequest->surname,
            roles: $userRequest->roles,
            isActive: $userRequest->isActive,
            id: $userRequest->idRequest->getId(),
            password: $password,
            passwordConfirmation: $userRequest->passwordRequest->passwordConfirmation,
            avatar: $userRequest->fileData,
        );
    }
}
