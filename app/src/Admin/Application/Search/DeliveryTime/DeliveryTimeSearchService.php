<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\DeliveryTime;

use App\Admin\Domain\Repository\DeliveryTimeRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class DeliveryTimeSearchService extends AbstractSearchService
{
    public function __construct(
        DeliveryTimeRepositoryInterface $repository,
        DeliveryTimeParserFactory $parserFactory,
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
