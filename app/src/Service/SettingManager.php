<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Shop\Response\Setting\SettingShopCategoryDTOResponse;
use App\Entity\Category;
use App\Entity\Currency;
use App\Entity\Setting;
use App\Enums\SettingType;
use App\Repository\CategoryRepository;
use App\Repository\SettingRepository;
use App\ValueObject\JsonData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SettingManager
{
    private SettingRepository $settingRepository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
        /** @var SettingRepository $settingRepository */
        $settingRepository = $this->entityManager->getRepository(Setting::class);
        $this->settingRepository = $settingRepository;
    }

    public function get(SettingType $type): ?Setting
    {
        return $this->settingRepository->findOneBy(['type' => $type]);
    }

    public function findDefaultCurrency(): Currency
    {
        /** @var Setting|null $setting */
        $setting = $this->settingRepository->findOneBy(['type' => SettingType::CURRENCY]);

        if (null === $setting) {
            throw new \LogicException('Default Currency not found');
        }

        $value = new JsonData($setting->getValue());

        $currency = $this->entityManager->getRepository(Currency::class)->find($value->get('id'));

        if (null === $currency) {
            throw new \LogicException('Default Currency not found');
        }

        return $currency;
    }

    /** @return array<string, string> */
    public function getMeta(): array
    {
        $metaSettings = $this->settingRepository->findAllMetaSettings();

        $settings = [];
        foreach ($metaSettings as $setting) {
            $settings[$setting->getType()->name] = $setting->getValue();
        }

        return $settings;
    }

    /** @return array<int, mixed> */
    public function getShopCategories(): array
    {
        /** @var ?Setting $menuSettings */
        $menuSettings = $this->settingRepository->findOneBy(['type' => SettingType::SHOP_CATEGORIES]);

        if (null === $menuSettings) {
            return [];
        }

        $jsonData = new JsonData($menuSettings->getValue());
        $idCategories = [];

        foreach ($jsonData->getArray() as $value) {
            $idCategories[] = $value['id'];
        }

        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        /** @var Category[] $categories */
        $categories = $categoryRepository->findBy(['id' => $idCategories, 'isActive' => true]);

        if (empty($categories)) {
            return [];
        }

        return array_map(function (Category $category) {
            $url = $this->urlGenerator->generate('shop.category_show', ['slug' => $category->getSlug()]);

            return SettingShopCategoryDTOResponse::fromArray([
                'name' => $category->getName(),
                'url' => $url,
            ]);
        }, $categories);
    }
}
