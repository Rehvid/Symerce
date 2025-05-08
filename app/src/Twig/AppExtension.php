<?php

declare(strict_types=1);

namespace App\Twig;

use App\DTO\Shop\Response\Setting\SettingShopCategoryDTOResponse;
use App\Entity\Category;
use App\Entity\Setting;
use App\Enums\SettingType;
use App\Repository\CategoryRepository;
use App\Repository\SettingRepository;
use App\Service\SettingManager;
use App\ValueObject\JsonData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(
        private readonly SettingManager $settingManager,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getSvgInline', [$this, 'getSvgInline']),
            new TwigFunction('getMeta', [$this, 'getMeta']),
            new TwigFunction('getMenuCategories', [$this, 'getMenuCategories']),
        ];
    }

    public function getSvgInline(string $path, string $classes = ''): string
    {
        $file = __DIR__ . '/../../public/' . $path;

        if (!file_exists($file)) {
            return '';
        }

        $svg = file_get_contents($file);

        if ($classes) {
            $svg = preg_replace('/<svg([^>]*?)\sclass="[^"]*"/i', '<svg$1', $svg);
            $svg = preg_replace('/<svg([^>]*)>/i', '<svg$1 class="' . htmlspecialchars($classes, ENT_QUOTES) . '">', $svg, 1);
        }

        return $svg;
    }

    public function getMeta(): array
    {
        return $this->settingManager->getMeta();
    }

    public function getMenuCategories(): array
    {
        return $this->settingManager->getShopCategories();
    }
}
