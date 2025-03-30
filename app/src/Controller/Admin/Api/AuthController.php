<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Controller\AbstractApiController;
use App\Dto\Request\User\SaveUserRequestDTO;
use App\Dto\Response\User\UserSessionResponseDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

#[Route('/auth', name: 'auth_')]
class AuthController extends AbstractApiController
{
    #[Route('/register', name: 'register', methods: ['POST'], format: 'json')]
    public function register(#[MapRequestPayload] SaveUserRequestDTO $saveUserDTO): JsonResponse
    {
        $this->dataPersisterManager->persist($saveUserDTO);

        return $this->prepareJsonResponse(statusCode: Response::HTTP_CREATED);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        TokenStorageInterface $tokenStorage
    ): JsonResponse {
        $eventDispatcher->dispatch(new LogoutEvent($request, $tokenStorage->getToken()));

        $response = new JsonResponse(['success' => true], Response::HTTP_OK);
        $response->headers->clearCookie('BEARER');

        return $response;
    }

    #[Route('/verify', name: 'verify_auth', methods: ['GET'])]
    public function verifyAuth(
        Request $request,
        JWTTokenManagerInterface $tokenManager,
        UserRepository $userRepository
    ): JsonResponse
    {
        $token = (string) $request->cookies->get('BEARER');

        if (!$token) {
            return $this->createUnauthorizedResponse("Token not found");
        }

        try {
            $decodedToken = $tokenManager->parse($token);
            if (isset($decodedToken['exp'])) {
                $expirationTime = $decodedToken['exp'];

                $currentTime = time();
                if ($expirationTime < $currentTime) {
                    return $this->createUnauthorizedResponse("Token expired");
                }
            }

            /** @var ?User $user */
            $user = $userRepository->loadUserByIdentifier($decodedToken['username']);
            if ($user) {
                return $this->prepareJsonResponse(
                    data: UserSessionResponseDTO::fromArray([
                        'email' => $user->getUserIdentifier(),
                        'firstname' => $user->getFirstname(),
                        'surname' => $user->getSurname(),
                        'roles' => $user->getRoles(),
                    ]),
                );
            }
        } catch (\Exception $e) {
            return $this->createUnauthorizedResponse("Could not parse token. " . $e->getMessage());
        }

        return $this->createUnauthorizedResponse("Unauthorized");
    }

    private function createUnauthorizedResponse(string $message): JsonResponse
    {
        return $this->prepareJsonResponse(
            data: [
                'status' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => $message,
            ],
            statusCode: Response::HTTP_UNAUTHORIZED
        );
    }
}
