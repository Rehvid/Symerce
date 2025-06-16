<?php

declare(strict_types=1);

namespace App\AdminEntry\Application\Handler;

use App\AdminEntry\Application\Provider\ReactDataProvider;
use App\AdminEntry\Application\Query\GetAdminEntryListQuery;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Application\Service\FileService;
use App\Common\Domain\ValueObject\JsonDataVO;

final readonly class AdminEntryListQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ReactDataProvider $reactDataProvider,
        private FileService $fileService
    ) {
    }

    /** @return array <string, mixed> */
    public function __invoke(GetAdminEntryListQuery $query): array
    {
        return [
            'data' => (new JsonDataVO($this->reactDataProvider->provide()))->getJson(),
            'logo' => $this->fileService->getLogoPublicPath()
        ];
    }
}
