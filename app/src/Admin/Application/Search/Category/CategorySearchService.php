<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Category;

use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
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
