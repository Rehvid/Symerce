<?php

declare(strict_types=1);

namespace App\Traits;

use App\DTO\Request\OrderRequestDTO;
use App\DTO\Request\PersistableInterface;
use App\Factory\PersistableDTOFactory;
use App\Interfaces\OrderSortableInterface;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Service\Response\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

trait UpdateOrderControllerTrait
{
    #[Route('/order', name: 'order', methods: ['PUT'])]
    public function order(Request $request, TranslatorInterface $translator): JsonResponse
    {
        if (!$this instanceof UpdateOrderControllerInterface) {
            throw new \LogicException('Class must implement UpdateOrderControllerInterface to use UpdateOrderControllerTrait');
        }

        $content = json_decode($request->getContent(), true);

        $orderRequestDTO = PersistableDTOFactory::create(OrderRequestDTO::class, [
            'movedId' => $content['movedId'] ?? null,
            'newPosition' => $content['newPosition'] ?? null,
            'oldPosition' => $content['oldPosition'] ?? null,
        ]);

        $this->reorderEntities($orderRequestDTO);

        return $this->createJsonResponse($translator);
    }

    private function reorderEntities(OrderRequestDTO|PersistableInterface $orderRequestDTO): void
    {
        $this->adjustOrderPositions($orderRequestDTO->oldPosition, $orderRequestDTO->newPosition);
        $this->updateMovedEntityOrder($orderRequestDTO->movedId, $orderRequestDTO->newPosition);
        $this->getEntityManager()->flush();
    }

    private function adjustOrderPositions(int $oldOrder, int $newOrder): void
    {
        $repository = $this->getOrderSortableRepository();

        /** @var OrderSortableInterface[] $entities */
        $entities = $repository->findItemsInOrderRange($oldOrder, $newOrder);

        foreach ($entities as $entity) {
            if ($oldOrder < $newOrder) {
                $entity->setOrder($entity->getOrder() - 1);
            } else {
                $entity->setOrder($entity->getOrder() + 1);
            }
        }
    }

    private function updateMovedEntityOrder(int $movedId, int $newOrder): void
    {
        $repository = $this->getOrderSortableRepository();

        /** @var OrderSortableInterface|null $movedEntity */
        $movedEntity = $repository->find($movedId);
        if (!$movedEntity) {
            throw new \RuntimeException("Not found movedId $movedId");
        }

        $movedEntity->setOrder($newOrder);
    }

    private function createJsonResponse(TranslatorInterface $translator): JsonResponse
    {
        $apiResponse = new ApiResponse(
            message: $translator->trans('base.messages.update_order')
        );

        return new JsonResponse(
            data: $apiResponse->toArray(),
            status: Response::HTTP_OK,
        );
    }
}
