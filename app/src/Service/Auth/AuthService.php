<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\DTO\Response\ErrorResponseDTO;
use App\DTO\Response\User\UserSessionResponseDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class AuthService
{
    public function __construct(
        private JWTTokenManagerInterface $tokenManager,
        private UserRepository $userRepository
    ) {
    }

    public function verifyUserAuthorization(Request $request): AuthorizationResult
    {
        $token = (string) $request->cookies->get('BEARER');
        if (!$token) {
            return $this->prepareResponseData(
                statusCode: Response::HTTP_UNAUTHORIZED,
                errorResponseDTO: $this->createErrorResponse('Token not found')
            );
        }

        $parseToken = $this->parseToken($token);
        if ($parseToken instanceof ErrorResponseDTO) {
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

    /** @return ErrorResponseDTO|array<string,mixed> */
    private function parseToken(string $token): ErrorResponseDTO|array
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

    private function createUserSessionResponseDTO(User $user): UserSessionResponseDTO
    {
        return UserSessionResponseDTO::fromArray([
            'id' => $user->getId(),
            'email' => $user->getUserIdentifier(),
            'firstname' => $user->getFirstname(),
            'surname' => $user->getSurname(),
            'roles' => $user->getRoles(),
            'fullName' => $user->getFullName(),
        ]);
    }

    private function createErrorResponse(string $message): ErrorResponseDTO
    {
        return ErrorResponseDTO::fromArray([
            'status' => false,
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => $message,
        ]);
    }

    private function prepareResponseData(
        ?UserSessionResponseDTO $userSessionResponseDTO = null,
        int $statusCode = Response::HTTP_OK,
        ?ErrorResponseDTO $errorResponseDTO = null,
    ): AuthorizationResult {
        return new AuthorizationResult(
            authorized: null === $errorResponseDTO,
            userSessionDTO: $userSessionResponseDTO,
            error: $errorResponseDTO,
            statusCode: $statusCode,
        );
    }
}
