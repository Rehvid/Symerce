<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler;

use App\DTO\Request\PersistableInterface;
use App\DTO\Request\Tag\SaveTagRequestDTO;
use App\Entity\Tag;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;

/**
 * @extends BaseEntityFiller<SaveTagRequestDTO>
 */
final class TagEntityFiller extends BaseEntityFiller
{
    public function toNewEntity(PersistableInterface|SaveTagRequestDTO $persistable): Tag
    {
        return $this->fillEntity($persistable, new Tag());
    }

    /**
     * @param Tag $entity
     */
    public function toExistingEntity(PersistableInterface|SaveTagRequestDTO $persistable, object $entity): Tag
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveTagRequestDTO::class;
    }

    /**
     * @param Tag $entity
     */
    protected function fillEntity(PersistableInterface|SaveTagRequestDTO $persistable, object $entity): Tag
    {
        $entity->setName($persistable->name);

        return $entity;
    }
}
