<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Tag;

use App\DTO\Request\Tag\SaveTagRequestDTO;
use App\Entity\Tag;
use App\Service\DataPersister\Base\UpdatePersister;

final class TagUpdatePersister extends UpdatePersister
{
    public function getSupportedClasses(): array
    {
        return [Tag::class, SaveTagRequestDTO::class];
    }
}
