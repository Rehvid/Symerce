<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\User\UserCreateFormResponse;
use App\Admin\Application\DTO\Response\User\UserFormResponse;
use App\Admin\Application\DTO\Response\User\UserListResponse;
use App\Admin\Domain\Enums\AdminRole;
use App\Entity\User;
use App\Utils\Utils;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class UserAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private TranslatorInterface $translator,
    ) {
    }

    /**
     * @param array<int, mixed> $paginatedData
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $userListCollection = array_map(
            fn (User $user) => $this->createUserListResponse($user),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($userListCollection);
    }

    public function toCreateFormDataResponse(): array
    {
        return $this->responseHelperAssembler->wrapAsFormData(
            new UserCreateFormResponse(
                availableRoles: $this->getAvailableRoles(),
            ),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(User $user): array
    {
        $avatar = $user->getAvatar();
        $file = $avatar === null
            ? null
            : $this->responseHelperAssembler->toFileResponse($image->getId(), $user->getFullName(), $image->getPath());

        return $this->responseHelperAssembler->wrapAsFormData(
            new UserFormResponse(
                firstname: $user->getFirstname(),
                surname: $user->getSurname(),
                email: $user->getEmail(),
                isActive: $user->isActive(),
                roles: $user->getRoles(),
                avatar: $file,
                availableRoles: $this->getAvailableRoles()
            )
        );
    }

    private function getAvailableRoles(): array
    {
        return Utils::buildSelectedOptions(
            AdminRole::cases(),
            fn (AdminRole $role) => $this->translator->trans('base.admin_role_type.' . strtolower($role->name)),
            fn (AdminRole $role) => $role->value,
        );
    }

    private function createUserListResponse(User $user): UserListResponse
    {
        return new UserListResponse(
            id: $user->getId(),
            fullName: $user->getFullName(),
            email: $user->getEmail(),
            isActive: $user->isActive(),
            imagePath: $this->responseHelperAssembler->buildPublicFilePath($user->getFile()?->getPath()),
        );
    }
}
