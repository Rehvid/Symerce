<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\PositionChangeRequest;
use App\Admin\Application\UseCase\Reorder\ReorderPositionsUseCase;
use App\Service\Response\ApiResponse;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ReorderController extends AbstractController
{
    public function __construct(
        private readonly RequestDtoResolver $requestDtoResolver,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/reorder/{entity}', name: 'reorder_entity', methods: ['PUT'])]
    public function reorder(
        string $entity,
        Request $request,
        ReorderPositionsUseCase $useCase,
    ): JsonResponse{
        $positionRequest = $this->requestDtoResolver->mapAndValidate($request, PositionChangeRequest::class);
        $useCase->execute($positionRequest, $entity);

        return $this->json(
            data: new ApiResponse(
                message: $this->translator->trans('base.messages.update_order')
            )
        );
    }
}
