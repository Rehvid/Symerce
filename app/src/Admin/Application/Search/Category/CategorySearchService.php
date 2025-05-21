<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Category;

use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Parser\SearchRequestParser;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class CategorySearchService extends AbstractSearchService
{
    private SearchRequestParser $parser;

    public function __construct(
        CategoryRepositoryInterface $repository,
        CategorySearchServiceFactory $parserFactory,
    ) {
        parent::__construct($repository);

        $this->parser = $parserFactory->create();
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parser->parse($request);
    }
}
