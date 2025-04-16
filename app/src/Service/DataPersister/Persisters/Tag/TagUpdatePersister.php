<?php

namespace App\Service\DataPersister\Persisters\Tag;

use App\DTO\Request\Tag\SaveTagRequestDTO;
use App\Entity\Tag;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;

class TagUpdatePersister extends UpdatePersister
{

    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
       $entity->setName($persistable->name);
       return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [Tag::class, SaveTagRequestDTO::class];
    }
}
