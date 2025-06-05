<?php

declare(strict_types=1);

namespace App\User\Application\Search;

use App\Common\Application\Search\AbstractSearchService;
use App\Common\Application\Search\Dto\SearchCriteria;
use App\Common\Application\Search\Dto\SearchData;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class UserSearchService extends AbstractSearchService
{
    public function __construct(
        UserRepositoryInterface $repository,
        UserSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(SearchData $searchData): SearchCriteria
    {
        return $this->parserFactory->create()->parse($searchData);
    }
}
