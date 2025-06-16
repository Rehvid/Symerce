<?php

declare(strict_types=1);

namespace App\User\Application\Assembler;

use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Domain\Entity\User;
use App\User\Application\Dto\Response\PersonalResponse;

final readonly class ProfileAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
    ) {
    }

    public function toPersonalResponse(User $user): array
    {
        return [
            'user' => $this->createPersonalResponse($user),
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
