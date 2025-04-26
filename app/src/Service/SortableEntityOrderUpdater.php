<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Request\OrderRequestDTO;
use App\Interfaces\OrderSortableInterface;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

readonly class SortableEntityOrderUpdater
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param class-string<OrderSortableInterface> $class
     */
    public function updateOrder(OrderRequestDTO $dto, string $class): void
    {
        if (!$this->isSortableClassAndValidOrder($dto, $class)) {
            return;
        }

        $repository = $this->entityManager->getRepository($class);
        $movedId = $dto->order['movedId'];
        $oldOrder = $dto->order['oldPosition'];
        $newOrder = $dto->order['newPosition'];

        if (!is_subclass_of($repository, OrderSortableRepositoryInterface::class)) {
            return;
        }

        /** @var OrderSortableInterface[] $entities */
        $entities = $repository->findItemsInOrderRange($oldOrder, $newOrder);

        foreach ($entities as $entity) {
            if ($oldOrder < $newOrder) {
                $entity->setOrder($entity->getOrder() - 1);
            } else {
                $entity->setOrder($entity->getOrder() + 1);
            }
        }

        $movedEntity = $repository->find($movedId);
        if (!$movedEntity) {
            throw new \RuntimeException("Not found movedId $movedId");
        }

        $movedEntity->setOrder($newOrder);

        $this->entityManager->flush();
    }

    private function isSortableClassAndValidOrder(OrderRequestDTO $dto, string $class): bool
    {
        return is_subclass_of($class, OrderSortableInterface::class) && !empty($dto->order);
    }
}
