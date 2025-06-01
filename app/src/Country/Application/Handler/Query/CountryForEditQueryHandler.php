<?php

declare(strict_types=1);

namespace App\Country\Application\Handler\Query;

use App\Common\Domain\Entity\Country;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Country\Application\Assembler\CountryAssembler;
use App\Country\Application\Query\GetCountryForEditQuery;
use App\Country\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;


final readonly class CountryForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CountryAssembler $assembler,
        private CountryRepositoryInterface $repository
    ) {}

    public function __invoke(GetCountryForEditQuery $query): array
    {
        /** @var ?Country $country */
        $country = $this->repository->findById($query->countryId);

        if (null === $country) {
            throw EntityNotFoundException::for(Country::class, $query->countryId);
        }

        return $this->assembler->toFormResponse($country);
    }
}
