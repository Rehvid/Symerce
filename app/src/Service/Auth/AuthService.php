<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Admin\Application\DTO\Response\FileResponse;
use App\Admin\Application\DTO\Response\User\UserSessionResponse;
use App\Admin\Application\Service\FileService;
use App\Admin\Infrastructure\Repository\UserDoctrineRepository;
use App\Entity\User;
use App\Shared\Application\DTO\Response\ApiErrorResponse;
use App\Shared\Domain\Enums\CookieName;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthService
{
    public function __construct(
        private JWTTokenManagerInterface $tokenManager,
        private UserDoctrineRepository   $userRepository,
        private FileService              $fileService,
    ) {
    }

    public function verifyUserAuthorization(Request $request): AuthorizationResult
    {
        $token = (string) $request->cookies->get(CookieName::ADMIN_BEARER->value);
        if (!$token) {
            return $this->prepareResponseData(
                statusCode: Response::HTTP_UNAUTHORIZED,
                errorResponseDTO: $this->createErrorResponse('Token not found')
            );
        }

        $parseToken = $this->parseToken($token);
        if ($parseToken instanceof ApiErrorResponse) {
            return $this->prepareResponseData(
                statusCode: Response::HTTP_UNAUTHORIZED,
                errorResponseDTO: $parseToken
            );
        }

        /** @var User|null $user */
        $user = $this->userRepository->loadUserByIdentifier($parseToken['username']);
        if (null !== $user) {
            return $this->prepareResponseData(
                userSessionResponseDTO: $this->createUserSessionResponseDTO($user),
            );
        }

        return $this->prepareResponseData(
            statusCode: Response::HTTP_UNAUTHORIZED,
            errorResponseDTO: $this->createErrorResponse('User not found')
        );
    }

    /** @return ApiErrorResponse|array<string,mixed> */
    private function parseToken(string $token): ApiErrorResponse|array
    {
        try {
            $decodedToken = $this->tokenManager->parse($token);

            if (isset($decodedToken['exp'])) {
                $expirationTime = $decodedToken['exp'];

                $currentTime = time();
                if ($expirationTime < $currentTime) {
                    return $this->createErrorResponse('Token expired');
                }
            }

            return $decodedToken;
        } catch (\Exception $e) {
            return $this->createErrorResponse('Could not parse token. '.$e->getMessage());
        }
    }

    private function createUserSessionResponseDTO(User $user): UserSessionResponse
    {
        $fullName = $user->getFullname();

        return UserSessionResponse::fromArray([
            'id' => $user->getId(),
            'email' => $user->getUserIdentifier(),
            'firstname' => $user->getFirstname(),
            'surname' => $user->getSurname(),
            'roles' => $user->getRoles(),
            'fullName' => $fullName,
            'avatar' => FileResponse::fromArray([
                'id' => $user->getAvatar()?->getId(),
                'name' => "Avatar - $fullName",
                'preview' => $this->fileService->preparePublicPathToFile($user->getAvatar()?->getPath()),
            ]),
        ]);
    }

    private function createErrorResponse(string $message): ApiErrorResponse
    {
        return ApiErrorResponse::fromArray([
            'status' => false,
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => $message,
        ]);
    }

    private function prepareResponseData(
        ?UserSessionResponse $userSessionResponseDTO = null,
        int                  $statusCode = Response::HTTP_OK,
        ?ApiErrorResponse    $errorResponseDTO = null,
    ): AuthorizationResult {
        return new AuthorizationResult(
            authorized: null === $errorResponseDTO,
            userSessionDTO: $userSessionResponseDTO,
            error: $errorResponseDTO,
            statusCode: $statusCode,
        );
    }
}
