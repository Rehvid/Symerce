<?php

declare(strict_types=1);

namespace App\Common\Ui\Controller\Api\Admin;

use App\Common\Application\Contracts\ReorderEntityServiceInterface;
use App\Common\Application\Dto\Request\PositionChangeRequest;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Infrastructure\Http\RequestDtoResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class PositionController extends AbstractController
{
    public function __construct(
        private readonly RequestDtoResolver $requestDtoResolver,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/api/admin/position/{entity}', name: 'api_admin_position_entity', methods: ['PUT'])]
    public function position(
        string $entity,
        Request $request,
        ReorderEntityServiceInterface $reorderEntityService,
    ): JsonResponse {
        $reorderEntityService->reorderEntityPositions(
            request: $this->requestDtoResolver->mapAndValidate($request, PositionChangeRequest::class),
            entityName: $entity
        );

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.update_order')
            )
        );
    }
}
