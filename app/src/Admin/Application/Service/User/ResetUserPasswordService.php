<?php

declare(strict_types=1);

namespace App\Admin\Application\Service\User;

use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Admin\Domain\Repository\UserTokenRepositoryInterface;
use App\Common\Domain\Entity\User;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class ResetUserPasswordService
{
    public function __construct(
        private UserTokenRepositoryInterface $userTokenRepository,
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function execute(UpdateSecurityRequest $changePasswordRequestDTO, string $token): ApiResponse
    {
        $userToken = $this->userTokenRepository->findByToken($token);

        if (null === $userToken) {
            return $this->buildErrorResult('Token not found', Response::HTTP_BAD_REQUEST);
        }

        /** @var ?User $user */
        $user = $this->userRepository->findById($userToken->getUser()->getId());
        if (null === $user) {
            return $this->buildErrorResult('User not found', Response::HTTP_BAD_REQUEST);
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $changePasswordRequestDTO->password));

        $this->userRepository->save($user);
        $this->userTokenRepository->remove($userToken);

        return new ApiResponse();
    }

    private function buildErrorResult(string $message, int $code): ApiResponse
    {
        return new ApiResponse(
            error: new ApiErrorResponse(
                code: $code,
                message: $message,
            )
        );
    }
}
