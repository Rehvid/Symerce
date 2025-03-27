<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Controller\AbstractApiController;
use App\Dto\Request\User\SaveUserDTO;
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
    public function register(#[MapRequestPayload] SaveUserDTO $saveUserDTO): JsonResponse
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
}
