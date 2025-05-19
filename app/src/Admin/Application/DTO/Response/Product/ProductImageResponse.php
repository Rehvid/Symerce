<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Response\Product;

use App\Admin\Application\DTO\Response\FileResponse;
use App\DTO\Admin\Response\ResponseInterfaceData;

final class ProductImageResponse extends FileResponse
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
