<?php

declare(strict_types=1);

namespace App\Carrier\Application\Handler\Query;

use App\Carrier\Application\Assembler\CarrierAssembler;
use App\Carrier\Application\Query\GetCarrierForEditQuery;
use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\Carrier;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class CarrierForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CarrierRepositoryInterface $repository,
        private CarrierAssembler $assembler,
    ) {
    }

    public function __invoke(GetCarrierForEditQuery $query): array
    {
        /** @var ?Carrier $carrier */
        $carrier = $this->repository->findById($query->carrierId);
        if (null === $carrier) {
            throw EntityNotFoundException::for(Carrier::class, $query->carrierId);
        }

        return $this->assembler->toFormDataResponse($carrier);
    }
}
