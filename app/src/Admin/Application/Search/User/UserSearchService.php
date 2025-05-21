<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\User;

use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class UserSearchService extends AbstractSearchService
{
    public function __construct(
        UserRepositoryInterface $repository,
        UserSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
