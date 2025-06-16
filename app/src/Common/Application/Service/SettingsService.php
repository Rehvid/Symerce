<?php

declare(strict_types=1);

namespace App\Common\Application\Service;

use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Currency;
use App\Common\Domain\Entity\Setting;
use App\Common\Domain\ValueObject\JsonDataVO;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingType;
use App\Setting\Domain\Repository\SettingRepositoryInterface;
use App\Shop\Application\DTO\Response\SettingShopCategoryResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class SettingsService
{
    public function __construct(
        private SettingRepositoryInterface $settingRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private CurrencyRepositoryInterface $currencyRepository,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function getByKey(SettingKey $type): ?Setting
    {
        return $this->settingRepository->findByKey($type);
    }

    public function findDefaultCurrency(): Currency
    {
        /** @var Setting|null $setting */
        $setting = $this->getByKey(SettingKey::CURRENCY);

        if (null === $setting) {
            throw new \LogicException('Default Currency not found');
        }


        $currency = $this->currencyRepository->findById($setting->getValue());
        if (null === $currency) {
            throw new \LogicException('Default Currency not found');
        }

        return $currency;
    }

    /** @return array<string, string> */
    public function getMeta(): array
    {
        $metaSettings = $this->settingRepository->findByType(SettingType::SEO);

        $settings = [];
        foreach ($metaSettings ?? [] as $setting) {
            $settings[$setting->getType()->name] = $setting->getValue();
        }

        return $settings;
    }

    /** @return array<int, mixed> */
    public function getShopCategories(): array
    {
        /** @var ?Setting $menuSettings */
        $menuSettings = $this->getByKey(SettingKey::SHOP_CATEGORIES);

        if (null === $menuSettings) {
            return [];
        }

        $jsonData = new JsonDataVO($menuSettings->getValue());
        $idCategories = [];

        foreach ($jsonData->getArray() as $value) {
            $idCategories[] = $value['id'];
        }

        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findBy(['id' => $idCategories, 'isActive' => true]);

        if (empty($categories)) {
            return [];
        }

        return array_map(fn (Category $category) => $this->createSettingShopCategoryResponse($category), $categories);
    }

    private function createSettingShopCategoryResponse(Category $category): SettingShopCategoryResponse
    {
        $url = $this->urlGenerator->generate('shop.category_show', ['slug' => $category->getSlug()]);

        return new SettingShopCategoryResponse(
            name: $category->getName(),
            url: $url
        );
    }
}
