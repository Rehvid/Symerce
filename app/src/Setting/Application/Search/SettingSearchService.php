<?php

declare(strict_types=1);

namespace App\Setting\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use App\Setting\Domain\Repository\SettingRepositoryInterface;
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
