<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Response\Form;

use App\Common\Application\Dto\Response\FileResponse;

final class ProductFormImageResponse extends FileResponse
{
    public function __construct(
        ?int $id,
        ?string $name,
        ?string $preview,
        public bool $isThumbnail,
    ) {
        parent::__construct($id, $name, $preview);
    }
}
