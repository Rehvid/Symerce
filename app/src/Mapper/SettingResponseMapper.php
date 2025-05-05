<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\ResponseInterfaceData;
use App\DTO\Response\Setting\SettingFormResponseDTO;
use App\DTO\Response\Setting\SettingIndexResponseDTO;
use App\DTO\Response\Setting\SettingUpdateFormResponseDTO;
use App\DTO\Response\Setting\SettingValueFormResponseDTO;
use App\Entity\Currency;
use App\Entity\Setting;
use App\Enums\SettingType;
use App\Enums\SettingValueType;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Utils\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class SettingResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private ResponseMapperHelper $responseMapperHelper,
    ) {
    }

    /**
     * @param array<int, mixed> $data
     *
     * @return array<int, mixed>
     */
    public function mapToIndexResponse(array $data = []): array
    {
        $settingData = array_map(fn (Setting $setting) => $this->createSettingIndexResponse($setting), $data);
        $additionalData = [
            'types' => $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::cases()),
        ];

        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            $settingData,
            $additionalData,
        );
    }

    private function createSettingIndexResponse(Setting $setting): ResponseInterfaceData
    {
        $type = $this->translator->trans("base.setting_type.{$setting->getType()->value}");
        $value = $setting->getValue();

        if (SettingType::CURRENCY === $setting->getType()) {
            $decodedValue = json_decode($value, true);
            $value = $this->entityManager->getRepository(Currency::class)->find($decodedValue['id'])?->getName();
        }

        return SettingIndexResponseDTO::fromArray([
            'id' => $setting->getId(),
            'name' => $setting->getName(),
            'value' => $value,
            'type' => $type,
            'isProtected' => $setting->isProtected(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function mapToStoreFormDataResponse(): array
    {
        $response = SettingFormResponseDTO::fromArray([
            'types' => $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::translatedOptions()),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var Setting $setting */
        $setting = $data['entity'];

        $settingValue = SettingValueFormResponseDTO::fromArray(['type' => SettingValueType::PLAIN_TEXT]);

        if (SettingType::CURRENCY === $setting->getType()) {
            $settingValue = $this->settingValueResponseDTOForCurrency();
        }

        $response = SettingUpdateFormResponseDTO::fromArray([
            'name' => $setting->getName(),
            'types' => $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::translatedOptions()),
            'type' => $setting->getType()->value,
            'value' => $setting->getValue(),
            'isProtected' => $setting->isProtected(),
            'settingValue' => $settingValue,
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }

    private function settingValueResponseDTOForCurrency(): ResponseInterfaceData
    {
        /** @var Currency[] $values */
        $values = $this->entityManager->getRepository(Currency::class)->findAll();

        return SettingValueFormResponseDTO::fromArray([
            'type' => SettingValueType::SELECT,
            'value' => Utils::buildSelectedOptions(
                $values,
                fn (Currency $currency) => $currency->getName(),
                fn (Currency $currency) => $currency->getId()
            ),
        ]);
    }

    /**
     * @param array <string, mixed> $types
     *
     * @return array<int, mixed>
     */
    private function buildTranslatedOptionsForSettingTypeEnum(array $types): array
    {
        return Utils::buildSelectedOptions(
            items: $types,
            labelCallback: fn (SettingType $type) => $this->translator->trans("base.setting_type.{$type->value}"),
            valueCallback: fn (SettingType $type) => $type->value,
        );
    }
}
