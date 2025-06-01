<?php

declare(strict_types=1);

namespace App\User\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Domain\Enums\AdminRole;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use App\Common\Domain\Entity\User;
use App\User\Application\Dto\Response\UserFormContext;
use App\User\Application\Dto\Response\UserFormResponse;
use App\User\Application\Dto\Response\UserListResponse;
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

    public function toFormContextResponse(): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            context: new UserFormContext(
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
            : $this->responseHelperAssembler->toFileResponse($avatar->getId(), $user->getFullName(), $avatar->getPath());

        return $this->responseHelperAssembler->wrapFormResponse(
            new UserFormResponse(
                firstname: $user->getFirstname(),
                surname: $user->getSurname(),
                email: $user->getEmail(),
                isActive: $user->isActive(),
                roles: $user->getRoles(),
                avatar: $file,
            ),
            context: new UserFormContext(
                availableRoles: $this->getAvailableRoles(),
            ),
        );
    }

    private function getAvailableRoles(): array
    {
        return ArrayUtils::buildSelectedOptions(
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
