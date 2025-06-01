<?php

declare(strict_types=1);

namespace App\Admin\Application\Service\User;

use App\Admin\Application\Contract\TokenParserInterface;
use App\Admin\Application\Contract\TokenProviderInterface;
use App\Admin\Application\DTO\AuthorizationResult;
use App\Admin\Application\DTO\Response\FileResponse;
use App\Admin\Application\Service\FileService;
use App\Common\Domain\Entity\User;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use App\User\Application\Dto\Response\UserSessionResponse;
use App\User\Domain\Repository\UserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthorizeUserService
{
    public function __construct(
        private TokenParserInterface $tokenParser,
        private TokenProviderInterface $tokenProvider,
        private UserRepositoryInterface  $userRepository,
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
        if (null !== $user->getAvatar()) {
            $fileResponse = new FileResponse(
                id: $user->getAvatar()->getId(),
                name: $fullName,
                preview:  $this->fileService->preparePublicPathToFile($user->getAvatar()?->getPath())
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
