<?php

declare(strict_types=1);

namespace App\Customer\Application\Search;

use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class CustomerSearchService extends AbstractSearchService
{

    public function __construct(
        CustomerRepositoryInterface $repository,
        CustomerSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
