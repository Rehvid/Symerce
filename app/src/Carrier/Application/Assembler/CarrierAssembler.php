<?php

declare(strict_types=1);

namespace App\Carrier\Application\Assembler;

use App\Carrier\Application\Dto\Response\CarrierFormResponse;
use App\Carrier\Application\Dto\Response\CarrierListResponse;
use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Application\Factory\MoneyFactory;
use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\Carrier;

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

        $thumbnail = $image === null
            ? null
            : $this->responseHelperAssembler->toFileResponse($image->getId(), $name, $image->getPath());

        return $this->responseHelperAssembler->wrapFormResponse(
            new CarrierFormResponse(
                name: $name,
                fee: $this->moneyFactory->create($carrier->getFee())->getFormattedAmount(),
                isActive: $carrier->isActive(),
                thumbnail: $thumbnail,
                isExternal: $carrier->isExternal(),
                externalData: $carrier->getExternalData(),
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
