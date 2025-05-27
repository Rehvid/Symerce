<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Customer;

use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use App\Shared\Domain\Repository\CustomerRepositoryInterface;
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
