<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\React;

use App\Admin\Application\Provider\ReactDataProvider;
use App\Admin\Application\Service\FileService;
use App\Admin\Domain\ValueObject\JsonData;
use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;

final readonly class ListReactUseCase implements QueryUseCaseInterface
{

    public function __construct(
        private ReactDataProvider $reactDataProvider,
        private FileService $fileService
    ) {
    }

    /** @return array<string, mixed> */
    public function execute(): array
    {
        return [
            'data' => (new JsonData($this->reactDataProvider->provide()))->getJson(),
            'logo' => $this->fileService->getLogoPublicPath()
        ];
    }
}
