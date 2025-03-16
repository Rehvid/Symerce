<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Dto\RegistrationDto;
use App\Service\Auth\RegisterUserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

#[Route("/api/auth", name: "api_auth_")]
class AuthController extends AbstractController
{
    #[Route('/register', name: "register", methods: ["POST"], format: "json")]
    public function register(
        #[MapRequestPayload] RegistrationDto $registrationDto,
        RegisterUserService $registerUserService
    ): JsonResponse
    {
        $registerUserService->register($registrationDto);

        return $this->json(["success" => true], Response::HTTP_CREATED);
    }

    #[Route("/logout", name: "logout", methods: ["POST"])]
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

    #[Route('/check-auth', name: 'check_auth')]
    public function checkAuth(Request $request, JWTTokenManagerInterface $tokenManager): JsonResponse
    {
        $token = $request->cookies->get('BEARER');

        if (!$token) {
            return new JsonResponse(['authenticated' => false], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $decodedToken = $tokenManager->parse($token);
            if (isset($decodedToken['exp'])) {
                $expirationTime = $decodedToken['exp'];

                $currentTime = time();
                if ($expirationTime < $currentTime) {
                    return new JsonResponse(['authenticated' => false], Response::HTTP_UNAUTHORIZED);
                }
            }
            if (isset($decodedToken['username'])) {
                return new JsonResponse(['authenticated' => true], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['authenticated' => false], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['authenticated' => false], Response::HTTP_UNAUTHORIZED);
    }
}
