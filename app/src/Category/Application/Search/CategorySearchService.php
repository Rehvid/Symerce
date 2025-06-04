<?php

declare(strict_types=1);

namespace App\Category\Application\Search;

use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class CategorySearchService extends AbstractSearchService
{

    public function __construct(
        CategoryRepositoryInterface $repository,
        CategorySearchParserFactory $parserFactory,
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
