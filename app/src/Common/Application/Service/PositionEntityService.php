<?php

declare(strict_types=1);

namespace App\Common\Application\Service;

use App\Common\Application\Contracts\ReorderEntityServiceInterface;
use App\Common\Application\Dto\Request\PositionChangeRequest;
use App\Common\Domain\Contracts\PositionEntityInterface;
use App\Common\Domain\Repository\PositionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class PositionEntityService implements ReorderEntityServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function reorderEntityPositions(PositionChangeRequest $request, string $entityName): void
    {
        $repository = $this->entityManager->getRepository($this->resolveEntityClass($entityName));
        if (!$repository instanceof PositionRepositoryInterface) {
            throw new \LogicException('Repository must implement PositionRepositoryInterface to use ReorderEntityService');
        }

        $this->adjustOrderPositions($repository, $request->oldPosition, $request->newPosition);
        $this->updateMovedEntityOrder($repository, $request->movedId, $request->newPosition);

        $this->entityManager->flush();
    }

    /** @return class-string<object> */
    private function resolveEntityClass(string $name): string
    {
        $class = 'App\\Common\\Domain\\Entity\\'.ucfirst($name);
        if (!class_exists($class)) {
            throw new \InvalidArgumentException("Entity class {$class} does not exist.");
        }

        return $class;
    }

    private function adjustOrderPositions(PositionRepositoryInterface $repository, int $oldOrder, int $newOrder): void
    {
        /** @var PositionEntityInterface[] $entities */
        $entities = $repository->findItemsInOrderRange($oldOrder, $newOrder);

        foreach ($entities as $entity) {
            $entity->setPosition(
                $oldOrder < $newOrder
                    ? $entity->getPosition() - 1
                    : $entity->getPosition() + 1
            );
        }
    }

    private function updateMovedEntityOrder(PositionRepositoryInterface $repository, int $movedId, int $newOrder): void
    {
        /** @var PositionEntityInterface|null $movedEntity */
        $movedEntity = $repository->findByMovedId($movedId);
        if (!$movedEntity) {
            throw new \RuntimeException("Not found movedId $movedId");
        }

        $movedEntity->setPosition($newOrder);
    }
}
