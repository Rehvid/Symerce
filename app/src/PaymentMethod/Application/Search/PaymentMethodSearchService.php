<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Search;

use App\Common\Application\Dto\Filter\SearchCriteria;
use App\Common\Application\Service\AbstractSearchService;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

final class PaymentMethodSearchService extends AbstractSearchService
{
    public function __construct(
        PaymentMethodRepositoryInterface $repository,
        PaymentMethodSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
