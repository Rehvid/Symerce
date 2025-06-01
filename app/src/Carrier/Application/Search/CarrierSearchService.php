<?php

declare (strict_types = 1);

namespace App\Carrier\Application\Search;

use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class CarrierSearchService extends AbstractSearchService
{
    public function __construct(
        CarrierRepositoryInterface $repository,
        CarrierSearchFactoryParser $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }


    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
