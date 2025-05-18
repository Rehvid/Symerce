<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Carrier;

use App\Admin\Application\Hydrator\CarrierHydrator;
use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Entity\Carrier;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateCarrierUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private CarrierRepositoryInterface $repository,
        private CarrierHydrator $hydrator,
    ) {
    }

    public function execute(RequestDtoInterface $requestDto): array
    {
        $carrier = new Carrier();

        $this->hydrator->hydrate($requestDto, $carrier);

        $this->repository->save($carrier);

        return (new IdResponse($carrier->getId()))->toArray();
    }
}
