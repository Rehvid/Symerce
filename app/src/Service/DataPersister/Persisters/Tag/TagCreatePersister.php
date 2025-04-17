<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Tag;

use App\DTO\Request\Tag\SaveTagRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class TagCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveTagRequestDTO::class];
    }
}
