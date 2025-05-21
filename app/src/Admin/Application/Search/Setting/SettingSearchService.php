<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Setting;

use App\Admin\Domain\Repository\SettingRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class SettingSearchService extends AbstractSearchService
{
    public function __construct(
        SettingRepositoryInterface $repository,
        SettingSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
