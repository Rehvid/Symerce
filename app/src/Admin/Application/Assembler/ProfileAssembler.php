<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Profile\PersonalResponse;
use App\Entity\User;

final readonly class ProfileAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
    ) {
    }

    public function toPersonalResponse(User $user): array
    {
        return [
            'user' => $this->createPersonalResponse($user)
        ];
    }

    private function createPersonalResponse(User $user): PersonalResponse
    {
        $fullName = $user->getFullName();
        $avatar = $user->getFile();

        return new PersonalResponse(
            firstname: $user->getFirstname(),
            surname: $user->getSurname(),
            email: $user->getEmail(),
            fullName: $fullName,
            avatar: $this->responseHelperAssembler->toFileResponse(
                id: $avatar?->getId(),
                name: $fullName,
                filePath: $avatar?->getPath()
            )
        );
    }
}
