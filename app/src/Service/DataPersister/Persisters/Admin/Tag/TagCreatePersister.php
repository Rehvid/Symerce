<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Admin\Tag;

use App\DTO\Admin\Request\Tag\SaveTagRequestDTO;
use App\Service\DataPersister\Base\CreatePersister;

final class TagCreatePersister extends CreatePersister
{
    public function getSupportedClasses(): array
    {
        return [SaveTagRequestDTO::class];
    }
}
