<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Profile\UpdatePersonalRequest;
use App\Admin\Application\DTO\Request\Profile\UpdateSecurityRequest;
use App\Admin\Application\UseCase\Profile\UpdatePersonalUseCase;
use App\Admin\Application\UseCase\Profile\UpdateSecurityUseCase;
use App\Admin\Domain\Entity\User;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/profiles', name: 'profile_')]
final class ProfileController extends AbstractController
{
    public function __construct(
        private readonly RequestDtoResolver $requestDtoResolver,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/{id}/personal', name: 'update_personal', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updatePersonal(Request $request, User $user, UpdatePersonalUseCase $useCase): JsonResponse
    {
        $personalRequest = $this->requestDtoResolver->mapAndValidate($request, UpdatePersonalRequest::class);

        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute($personalRequest, $user),
                message: $this->translator->trans('base.messages.update')
            )
        );
    }

    #[Route('/{id}/security', name: 'update_security', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updateSecurity(User $user, Request $request, UpdateSecurityUseCase $useCase): JsonResponse
    {
        $securityRequest = $this->requestDtoResolver->mapAndValidate($request, UpdateSecurityRequest::class);
        $useCase->execute($securityRequest, $user);

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.update')
            )
        );
    }
}
