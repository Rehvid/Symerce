<?php

declare(strict_types = 1);

namespace App\Admin\Application\Search\Tag;

use App\Admin\Domain\Repository\TagRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class TagSearchService extends AbstractSearchService
{
    public function __construct(
        TagRepositoryInterface $repository,
        TagSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
