<?php

declare(strict_types=1);

namespace App\Currency\Application\Handler\Query;

use App\Common\Domain\Entity\Currency;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Currency\Application\Assembler\CurrencyAssembler;
use App\Currency\Application\Query\GetCurrencyForEditQuery;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CurrencyForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CurrencyAssembler $assembler,
        private CurrencyRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetCurrencyForEditQuery $query): array
    {
        /** @var ?Currency $currency */
        $currency = $this->repository->findById($query->currencyId);
        if (null === $currency) {
            throw EntityNotFoundException::for(Currency::class, $query->currencyId);
        }

        return $this->assembler->toFormDataResponse($currency);
    }
}
