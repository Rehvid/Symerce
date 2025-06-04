<?php

declare(strict_types=1);

namespace App\Customer\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
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
