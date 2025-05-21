<?php

declare(strict_types=1);

namespace App\Admin\Application\Search\Vendor;

use App\Admin\Domain\Repository\VendorRepositoryInterface;
use App\Shared\Application\DTO\Filter\SearchCriteria;
use App\Shared\Application\Search\AbstractSearchService;
use Symfony\Component\HttpFoundation\Request;

final class VendorSearchService extends AbstractSearchService
{
    public function __construct(
        VendorRepositoryInterface $repository,
        VendorSearchParserFactory $parserFactory
    ) {
        parent::__construct($repository, $parserFactory);
    }

    public function buildSearchCriteria(Request $request): SearchCriteria
    {
        return $this->parserFactory->create()->parse($request);
    }
}
