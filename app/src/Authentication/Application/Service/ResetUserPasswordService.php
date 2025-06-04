<?php

declare(strict_types=1);

namespace App\Authentication\Application\Service;

use App\Common\Application\Dto\Response\ApiErrorResponse;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\Repository\UserTokenRepositoryInterface;
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

    public function execute(string $newPassword, string $token): ApiResponse
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

        $user->setPassword($this->passwordHasher->hashPassword($user, $newPassword));

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
