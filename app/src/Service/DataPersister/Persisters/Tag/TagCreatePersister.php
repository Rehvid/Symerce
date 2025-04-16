<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Tag;

use App\DTO\Request\Tag\SaveTagRequestDTO;
use App\Entity\Tag;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;

class TagCreatePersister extends CreatePersister
{

    protected function createEntity(PersistableInterface $persistable): object
    {
        $tag = new Tag();
        $tag->setName($persistable->name);

        return $tag;
    }

    public function getSupportedClasses(): array
    {
        return [SaveTagRequestDTO::class];
    }
}
