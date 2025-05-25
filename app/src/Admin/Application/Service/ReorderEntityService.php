<?php

declare(strict_types=1);

namespace App\Admin\Application\Service;

use App\Admin\Application\Contract\ReorderEntityServiceInterface;
use App\Admin\Application\DTO\Request\PositionChangeRequest;
use App\Admin\Domain\Contract\OrderEntityInterface;
use App\Admin\Domain\Repository\ReorderableRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

readonly final class ReorderEntityService implements ReorderEntityServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function reorderEntityPositions(PositionChangeRequest $request, string $entityName): void
    {
        $repository = $this->entityManager->getRepository($this->resolveEntityClass($entityName));
        if (!$repository instanceof ReorderableRepositoryInterface) {
            throw new \LogicException('Repository must implement ReorderableRepositoryInterface to use ReorderEntityService');
        }

        $this->adjustOrderPositions($repository, $request->oldPosition, $request->newPosition);
        $this->updateMovedEntityOrder($repository, $request->movedId, $request->newPosition);

        $this->entityManager->flush();
    }

    private function resolveEntityClass(string $name): string
    {
        $class = 'App\\Admin\\Domain\\Entity\\' . ucfirst($name);
        if (!class_exists($class)) {
            throw new \InvalidArgumentException("Entity class {$class} does not exist.");
        }

        return $class;
    }

    private function adjustOrderPositions(ReorderableRepositoryInterface $repository, int $oldOrder, int $newOrder): void
    {
        /** @var OrderEntityInterface[] $entities */
        $entities = $repository->findItemsInOrderRange($oldOrder, $newOrder);

        foreach ($entities as $entity) {
            $entity->setOrder(
                $oldOrder < $newOrder
                    ? $entity->getOrder() - 1
                    : $entity->getOrder() + 1
            );
        }
    }

    private function updateMovedEntityOrder(ReorderableRepositoryInterface $repository, $movedId, int $newOrder): void
    {
        /** @var OrderEntityInterface|null $movedEntity */
        $movedEntity = $repository->find($movedId);
        if (!$movedEntity) {
            throw new \RuntimeException("Not found movedId $movedId");
        }

        $movedEntity->setOrder($newOrder);
    }
}
