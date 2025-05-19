<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\DeliveryTime;

use App\Admin\Application\Assembler\DeliveryTimeAssembler;
use App\Shared\Application\UseCases\Base\QueryUseCaseInterface;

final readonly class GetDeliveryTimeCreateDataUseCase implements QueryUseCaseInterface
{

    public function __construct(
        private DeliveryTimeAssembler $deliveryTimeAssembler,
    ) {
    }

    public function execute(): mixed
    {
        return $this->deliveryTimeAssembler->toCreateFormDataResponse();
    }
}
