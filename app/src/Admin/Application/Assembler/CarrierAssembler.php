<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Carrier\CarrierFormResponse;
use App\Admin\Application\DTO\Response\Carrier\CarrierListResponse;
use App\Admin\Application\Service\FileService;
use App\Entity\Carrier;
use App\Shared\Application\Factory\MoneyFactory;

final readonly class CarrierAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private MoneyFactory $moneyFactory,
        private FileService $fileService,
    ) {
    }

    /**
     * @param array<int, mixed> $paginatedData
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $carrierListCollection = array_map(
            fn (Carrier $carrier) => $this->createCarrierListResponse($carrier),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($carrierListCollection);
    }

    public function toFormDataResponse(Carrier $carrier): array
    {
        $image = $carrier->getFile();
        $name = $carrier->getName();

        $file = $image === null
            ? null
            : $this->responseHelperAssembler->toFileResponse($image->getId(), $name, $image->getPath());

        return $this->responseHelperAssembler->wrapAsFormData(
            new CarrierFormResponse(
                name: $name,
                fee: $this->moneyFactory->create($carrier->getFee()),
                isActive: $carrier->isActive(),
                image: $file,
            ),
        );
    }

    private function createCarrierListResponse(Carrier $carrier): CarrierListResponse
    {
        return new CarrierListResponse(
            id: $carrier->getId(),
            name: $carrier->getName(),
            isActive: $carrier->isActive(),
            fee: $this->moneyFactory->create($carrier->getFee()),
            imagePath: $this->fileService->preparePublicPathToFile($carrier->getFile()?->getPath()),
        );
    }
}
