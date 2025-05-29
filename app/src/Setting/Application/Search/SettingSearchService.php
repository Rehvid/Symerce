<?php

declare(strict_types=1);

namespace App\Setting\Application\Search;

use App\Setting\Domain\Repository\SettingRepositoryInterface;
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
