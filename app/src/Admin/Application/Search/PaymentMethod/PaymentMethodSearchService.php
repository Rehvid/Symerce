<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\PaymentMethod;

use App\Admin\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
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
