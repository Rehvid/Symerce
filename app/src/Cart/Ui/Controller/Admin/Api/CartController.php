<?php

declare(strict_types=1);

namespace App\Cart\Ui\Controller\Admin\Api;

use App\Cart\Application\Query\GetCartDetailQuery;
use App\Cart\Application\Query\GetCartListQuery;
use App\Common\Application\Dto\Response\ApiResponse;
use App\Common\Ui\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/carts', name: 'api_admin_cart_')]
final class CartController extends AbstractApiController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->queryBus->ask(new GetCartListQuery($request)),
        );
    }

    #[Route('/{id}/details', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $this->queryBus->ask(
                    new GetCartDetailQuery(
                        cartId: $id
                    )
                ),
            )
        );
    }
}
