<?php

declare(strict_types=1);

namespace App\Traits;

use App\DTO\Request\FileRequestDTO;
use App\Enums\FileMimeType;
use App\Factory\PersistableDTOFactory;

trait FileTransformerTrait
{

    /**
     * @param array $file
     * @return array<string, mixed>
     * @throws \ReflectionException
     */
    public function transformToFileRequestDTO(array $file): array
    {
        return array_map(function ($item) {
            return PersistableDTOFactory::create(FileRequestDTO::class, [
                'size' => $item['size'] ?? null,
                'name' => $item['name'] ?? null,
                'type' => FileMimeType::tryFrom($item['type'] ?? null),
                'content' => $item['content'] ?? null,
            ]);
        }, $file);
    }
}
