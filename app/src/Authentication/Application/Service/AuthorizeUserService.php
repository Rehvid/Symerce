<?php

declare(strict_types=1);

namespace App\Authentication\Application\Service;

use App\Authentication\Application\Dto\AuthorizationResult;
use App\Common\Application\Contracts\TokenParserInterface;
use App\Common\Application\Contracts\TokenProviderInterface;
use App\Common\Application\Dto\Response\ApiErrorResponse;
use App\Common\Application\Dto\Response\FileResponse;
use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\File;
use App\Common\Domain\Entity\User;
use App\User\Application\Dto\Response\UserSessionResponse;
use App\User\Domain\Repository\UserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthorizeUserService
{
    public function __construct(
        private TokenParserInterface $tokenParser,
        private TokenProviderInterface $tokenProvider,
        private UserRepositoryInterface $userRepository,
        private FileService $fileService,
    ) {
    }

    public function verifyUserAuthorization(): AuthorizationResult
    {
        try {
            $token = $this->tokenProvider->getToken();
            $claims = $this->tokenParser->parse($token);
        } catch (InvalidTokenException $e) {
            return $this->buildErrorResult($e->getMessage());
        }

        $username = $claims['username'] ?? null;
        if (!$username) {
            return $this->buildErrorResult('Token missing username claim');
        }

        /** @var ?User $user */
        $user = $this->userRepository->loadUserByIdentifier($username);
        if (null === $user) {
            return $this->buildErrorResult('User not found');
        }

        $userSession = $this->createUserSessionResponseDTO($user);

        return new AuthorizationResult(
            authorized: true,
            userSessionDTO: $userSession,
            error: null,
            statusCode: Response::HTTP_OK
        );
    }

    private function createUserSessionResponseDTO(User $user): UserSessionResponse
    {
        $fullName = $user->getFullname();
        $fileResponse = null;
        $avatar = $user->getAvatar();
        if (null !== $avatar) {
            /** @var File $avatar */
            $fileResponse = new FileResponse(
                id: $avatar->getId(),
                name: $fullName,
                preview: $this->fileService->preparePublicPathToFile($avatar->getPath())
            );
        }

        return new UserSessionResponse(
            id: $user->getId(),
            email: $user->getEmail(),
            firstname: $user->getFirstName(),
            surname: $user->getSurname(),
            roles: $user->getRoles(),
            fullName: $fullName,
            avatar: $fileResponse
        );
    }

    private function buildErrorResult(string $message): AuthorizationResult
    {
        return new AuthorizationResult(
            authorized: false,
            userSessionDTO: null,
            error: new ApiErrorResponse(code: Response::HTTP_UNAUTHORIZED, message: $message),
            statusCode: Response::HTTP_UNAUTHORIZED
        );
    }
}
