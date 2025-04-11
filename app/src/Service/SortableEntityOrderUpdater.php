<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Request\OrderRequestDTO;
use App\Interfaces\OrderSortableInterface;
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
        $orderedIds = $dto->order;
        $entities = $repository->findBy(['id' => $orderedIds]);

        $orderMap = array_flip($orderedIds);

        /** @var OrderSortableInterface $entity */
        foreach ($entities as $entity) {
            $this->setEntityOrderPosition($entity, $orderMap);
        }

        $this->entityManager->flush();
    }

    private function isSortableClassAndValidOrder(OrderRequestDTO $dto, string $class): bool
    {
        return is_subclass_of($class, OrderSortableInterface::class) && !empty($dto->order);
    }

    /** @param array<int, int> $orderMap */
    private function setEntityOrderPosition(OrderSortableInterface $entity, array $orderMap): void
    {
        $id = $entity->getId();

        if (!isset($orderMap[$id])) {
            return;
        }

        $entity->setOrder($orderMap[$id]);
        $this->entityManager->persist($entity);
    }
}
