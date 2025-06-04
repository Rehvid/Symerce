<?php

declare(strict_types=1);

namespace App\AdminEntry\Application\Handler;

use App\Admin\Application\Service\FileService;
use App\Admin\Domain\ValueObject\JsonData;
use App\AdminEntry\Application\Provider\ReactDataProvider;
use App\AdminEntry\Application\Query\GetAdminEntryListQuery;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class AdminEntryListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ReactDataProvider $reactDataProvider,
        private FileService $fileService
    ) {
    }

    public function __invoke(GetAdminEntryListQuery $query): array
    {
        return [
            'data' => (new JsonData($this->reactDataProvider->provide()))->getJson(),
            'logo' => $this->fileService->getLogoPublicPath()
        ];
    }
}
