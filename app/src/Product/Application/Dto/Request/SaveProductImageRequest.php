<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Request;

use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Domain\Enums\FileMimeType;
use App\Common\Infrastructure\Utils\BoolHelper;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveProductImageRequest
{
    #[Assert\Valid]
    public IdRequest $fileId;

    public bool $isThumbnail;

    #[Assert\Valid]
    public ?FileData $uploadData;

    public function __construct(
        mixed $isThumbnail,
        ?string $name,
        ?string $type,
        ?string $content,
        ?int $size,
        int|string|null $id = null,
    ) {
        $this->fileId = new IdRequest($id);
        $this->isThumbnail = BoolHelper::castOrFail($isThumbnail, 'isThumbnail');
        $this->uploadData = null === $id ? new FileData(
            (int) $size,
            (string) $name,
            FileMimeType::from((string) $type),
            (string) $content
        ) : null;
    }
}
