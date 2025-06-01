<?php

declare(strict_types=1);

namespace App\Brand\Application\Search;

use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class BrandSearchService extends AbstractSearchService
{
    public function __construct(
        BrandRepositoryInterface  $repository,
        BrandSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
