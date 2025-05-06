<?php

declare(strict_types=1);

namespace App\DTO\Admin\Response\Product;

use App\DTO\Admin\Response\FileResponseDTO;
use App\DTO\Admin\Response\ResponseInterfaceData;

class ProductImageResponseDTO extends FileResponseDTO
{
    public function __construct(
        ?int $id,
        ?string $name,
        ?string $preview,
        public bool $isThumbnail,
    ) {
        parent::__construct($id, $name, $preview);
    }

    public static function fromArray(array $data): ResponseInterfaceData
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            preview: $data['preview'],
            isThumbnail: $data['isThumbnail'],
        );
    }
}
