<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Setting\SettingCreateFormResponse;
use App\Admin\Application\DTO\Response\Setting\SettingFormResponse;
use App\Admin\Application\DTO\Response\Setting\SettingListResponse;
use App\Admin\Application\DTO\Response\Setting\SettingValueResponse;
use App\Admin\Domain\Entity\Category;
use App\Admin\Domain\Entity\Currency;
use App\Admin\Domain\Entity\Setting;
use App\Admin\Domain\Enums\SettingValueType;
use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Admin\Domain\Repository\CurrencyRepositoryInterface;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use App\DTO\Admin\Response\ResponseInterfaceData;
use App\Shared\Domain\Enums\SettingType;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class SettingAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private CurrencyRepositoryInterface $currencyRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private TranslatorInterface $translator,
    ) {
    }

    public function toListResponse(array $paginatedData): array
    {
        $settingListCollection = array_map(
            fn (Setting $setting) => $this->createSettingListResponse($setting),
            $paginatedData
        );

        $additionalData = [
            'types' => $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::cases()),
        ];

        return $this->responseHelperAssembler->wrapListWithAdditionalData($settingListCollection, $additionalData);
    }

    public function toCreateFormDataResponse(): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            new SettingCreateFormResponse(
                availableTypes: $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::translatedOptions()),
                settingValue: new SettingValueResponse(type: SettingValueType::PLAIN_TEXT)
            ),
        );
    }

    public function toFormDataResponse(Setting $setting): array
    {
        $settingValue = new SettingValueResponse(
            type: SettingValueType::PLAIN_TEXT
        );

        if (SettingType::CURRENCY === $setting->getType()) {
            $settingValue = $this->settingValueResponseDTOForCurrency();
        }
        if (SettingType::SHOP_CATEGORIES === $setting->getType()) {
            $settingValue = $this->settingValueResponseDTOForShopCategories();
        }

        return $this->responseHelperAssembler->wrapFormResponse(
            new SettingFormResponse(
                name: $setting->getName(),
                type: $setting->getType()->value,
                value: $setting->getValue(),
                isProtected: $setting->isProtected(),
                availableTypes: $this->buildTranslatedOptionsForSettingTypeEnum(SettingType::translatedOptions()),
                settingValue: $settingValue
            ),
        );
    }

    private function settingValueResponseDTOForCurrency(): SettingValueResponse
    {
        /** @var Currency[] $values */
        $values = $this->currencyRepository->findAll();

        return new SettingValueResponse(
            type: SettingValueType::SELECT,
            value: ArrayUtils::buildSelectedOptions(
                $values,
                fn (Currency $currency) => $currency->getName(),
                fn (Currency $currency) => $currency->getId()
            ),
        );
    }

    private function settingValueResponseDTOForShopCategories(): ResponseInterfaceData
    {
        /** @var Category[] $values */
        $values = $this->categoryRepository->findAll();

        return new SettingValueResponse(
            type: SettingValueType::MULTI_SELECT,
            value: ArrayUtils::buildSelectedOptions(
                $values,
                fn (Category $category) => $category->getName(),
                fn (Category $category) => $category->getId(),
            ),
        );
    }


    private function createSettingListResponse(Setting $setting): SettingListResponse
    {
        $type = $this->translator->trans("base.setting_type.{$setting->getType()->value}");

        return new SettingListResponse(
            id: $setting->getId(),
            name: $setting->getName(),
            type: $type,
            isActive: $setting->isActive(),
            isProtected: $setting->isProtected(),
        );
    }

    /**
     * @param array<mixed, mixed> $types
     *
     * @return array<int, mixed>
     */
    private function buildTranslatedOptionsForSettingTypeEnum(array $types): array
    {
        return ArrayUtils::buildSelectedOptions(
            items: $types,
            labelCallback: fn (SettingType $type) => $this->translator->trans("base.setting_type.{$type->value}"),
            valueCallback: fn (SettingType $type) => $type->value,
        );
    }
}
