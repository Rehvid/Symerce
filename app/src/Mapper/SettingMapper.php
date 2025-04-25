<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\ResponseInterfaceData;
use App\DTO\Response\Setting\SettingIndexResponseDTO;
use App\DTO\Response\Setting\SettingUpdateFormResponseDTO;
use App\DTO\Response\Setting\SettingValueFormResponseDTO;
use App\Entity\Currency;
use App\Entity\Setting;
use App\Enums\SettingType;
use App\Enums\SettingValueType;
use App\Utils\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class SettingMapper
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface    $translator,
    ) {}

    public function mapToIndex(array $data): array
    {
        return array_map(function (Setting $setting) {
            $type = $this->translator->trans("base.setting_type.{$setting->getType()->value}");
            $value = $setting->getValue();

            if ($setting->getType() === SettingType::CURRENCY) {
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

        }, $data);
    }

    public function mapToShowUpdateFormData(Setting $setting): ResponseInterfaceData
    {
        $settingValue = SettingValueFormResponseDTO::fromArray(['type' => SettingValueType::PLAIN_TEXT]);

        if ($setting->getType() === SettingType::CURRENCY) {
            $settingValue = $this->settingValueResponseDTOForCurrency();
        }

        return SettingUpdateFormResponseDTO::fromArray([
            'name' => $setting->getName(),
            'types' => $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::translatedOptions()),
            'type' => $setting->getType()->value,
            'value' => $setting->getValue(),
            'isProtected' => $setting->isProtected(),
            'settingValue' => $settingValue
        ]);
    }

    private function settingValueResponseDTOForCurrency(): ResponseInterfaceData
    {
        $values = $this->entityManager->getRepository(Currency::class)->findAll();

        return SettingValueFormResponseDTO::fromArray([
            'type' => SettingValueType::SELECT,
            'value' => Utils::buildSelectedOptions(
                $values,
                fn (Currency $currency) => $currency->getName(),
                fn (Currency $currency) => $currency->getId()
            )
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
