<?php

declare(strict_types=1);

namespace App\Mapper\Admin;

use App\DTO\Admin\Response\ResponseInterfaceData;
use App\DTO\Admin\Response\User\UserFormResponseDTO;
use App\DTO\Admin\Response\User\UserIndexResponseDTO;
use App\Entity\User;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;

final readonly class UserResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private ResponseMapperHelper $responseMapperHelper,
    ) {
    }

    public function mapToIndexResponse(array $data = []): array
    {
        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (User $user) => $this->createUserIndexResponse($user), $data)
        );
    }

    private function createUserIndexResponse(User $user): ResponseInterfaceData
    {
        return UserIndexResponseDTO::fromArray([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'fullName' => $user->getFullName(),
            'isActive' => $user->isActive(),
            'imagePath' => $this->responseMapperHelper->buildPublicFilePath($user->getAvatar()?->getPath()),
        ]);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var User $user */
        $user = $data['entity'];

        $fullName = $user->getFullName();
        $avatar = $user->getAvatar();

        $response = UserFormResponseDTO::fromArray([
            'firstname' => $user->getFirstname(),
            'surname' => $user->getSurname(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'isActive' => $user->isActive(),
            'avatar' => $this->responseMapperHelper->createFileResponseData(
                $avatar?->getId(),
                $fullName,
                $avatar?->getPath(),
            ),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
