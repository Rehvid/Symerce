<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\Carrier\CarrierFormResponseDTO;
use App\DTO\Response\Carrier\CarrierIndexResponseDTO;
use App\DTO\Response\ResponseInterfaceData;
use App\Entity\Carrier;
use App\Entity\Currency;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Service\SettingManager;
use App\ValueObject\Money;

final readonly class CarrierResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private ResponseMapperHelper $responseMapperHelper,
        private SettingManager $settingManager
    ) {
    }

    public function mapToIndexResponse(array $data = []): array
    {
        $defaultCurrency = $this->settingManager->findDefaultCurrency();

        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (Carrier $carrier) => $this->createCarrierIndexResponse($carrier, $defaultCurrency), $data)
        );
    }

    private function createCarrierIndexResponse(Carrier $carrier, Currency $currency): ResponseInterfaceData
    {
        return CarrierIndexResponseDTO::fromArray([
            'id' => $carrier->getId(),
            'name' => $carrier->getName(),
            'isActive' => $carrier->isActive(),
            'fee' => new Money($carrier->getFee(), $currency),
            'imagePath' => $this->responseMapperHelper->buildPublicFilePath($carrier->getImage()?->getPath()),
        ]);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var Carrier $carrier */
        $carrier = $data['carrier'];
        $name = $carrier->getName();
        $image = $carrier->getImage();

        $response = CarrierFormResponseDTO::fromArray([
            'name' => $name,
            'fee' => new Money($carrier->getFee(), $this->settingManager->findDefaultCurrency()),
            'isActive' => $carrier->isActive(),
            'image' => $this->responseMapperHelper->createFileResponseData($image?->getId(), $name, $image?->getPath()),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
