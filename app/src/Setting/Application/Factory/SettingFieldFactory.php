<?php

declare(strict_types=1);

namespace App\Setting\Application\Factory;

use App\Admin\Domain\Entity\Category;
use App\Admin\Domain\Entity\Currency;
use App\Admin\Domain\Entity\Setting;
use App\Admin\Infrastructure\Utils\ArrayUtils;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;
use App\Setting\Application\Dto\SettingField;
use App\Setting\Domain\Enums\SettingInputType;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingValueType;
use App\Setting\Domain\ValueObject\SettingValueVO;

final readonly class SettingFieldFactory
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CurrencyRepositoryInterface $currencyRepository,
    ) {
    }

    public function create(Setting $setting): SettingField
    {
        $valueVO = new SettingValueVO($setting->getValueType(), $setting->getValue());

        return new SettingField(
            type: $setting->getValueType(),
            inputType: $this->resolveInputType($setting->getKey(), $setting->getValueType()),
            value: $setting->getValueType() === SettingValueType::JSON
                ? $valueVO->decodeJson($valueVO->getValue())
                : $valueVO->getValue(),
            availableOptions: $this->resolveOptions($setting),
        );
    }

    private function resolveInputType(SettingKey $key, SettingValueType $defaultType): SettingInputType
    {
        return match ($key) {
            SettingKey::SHOP_DESCRIPTION, SettingKey::SHOP_OG_DESCRIPTION => SettingInputType::RAW_TEXTAREA,
            SettingKey::SHOP_CATEGORIES => SettingInputType::MULTISELECT,
            SettingKey::CURRENCY => SettingInputType::SELECT,
            default => match ($defaultType) {
                SettingValueType::BOOLEAN => SettingInputType::CHECKBOX,
                SettingValueType::JSON => SettingInputType::MULTISELECT,
                SettingValueType::INTEGER => SettingInputType::NUMBER,
                default => SettingInputType::TEXT,
            }
        };
    }

    private function resolveOptions(Setting $setting): array
    {

        if ($setting->getKey() === SettingKey::SHOP_CATEGORIES) {
            return ArrayUtils::buildSelectedOptions(
                $this->categoryRepository->findBy(['isActive' => true]),
                fn (Category $category) => $category->getName(),
                fn (Category $category) => $category->getId(),
            );
        }

        if ($setting->getKey() === SettingKey::CURRENCY) {
            return ArrayUtils::buildSelectedOptions(
                $this->currencyRepository->findAll(),
                fn (Currency $currency) => $currency->getName(),
                fn (Currency $currency) => $currency->getId(),
            );
        }

        return [];
    }
}
