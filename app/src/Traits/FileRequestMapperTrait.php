<?php

declare(strict_types=1);

namespace App\Traits;

use App\DTO\Request\FileRequestDTO;
use App\DTO\Request\PersistableInterface;
use App\Enums\FileMimeType;
use App\Factory\PersistableDTOFactory;

trait FileRequestMapperTrait
{
    /**
     * @return array<string, mixed>
     *
     * @throws \ReflectionException
     */
    public function createFileRequestDTOs(array $file): array
    {
        return array_map(fn ($item) => $this->createFileRequestDTO($item), $file);
    }

    /**
     * @param array<string, mixed> $item
     *
     * @throws \ReflectionException
     */
    private function createFileRequestDTO(array $item): PersistableInterface|FileRequestDTO
    {
        return PersistableDTOFactory::create(FileRequestDTO::class, [
            'size' => $item['size'] ?? null,
            'name' => $item['name'] ?? null,
            'type' => FileMimeType::tryFrom($item['type'] ?? null),
            'content' => $item['content'] ?? null,
        ]);
    }
}
