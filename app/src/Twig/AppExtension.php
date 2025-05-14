<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Cart;
use App\Enums\CookieName;
use App\Service\CookieManager;
use App\Service\SettingManager;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(
        private readonly SettingManager $settingManager,
        private readonly CookieManager $cookieManager,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getSvgInline', [$this, 'getSvgInline']),
            new TwigFunction('getMeta', [$this, 'getMeta']),
            new TwigFunction('getMenuCategories', [$this, 'getMenuCategories']),
            new TwigFunction('getCart', [$this, 'getCart']),
        ];
    }

    public function getSvgInline(string $path, string $classes = ''): string
    {
        $file = __DIR__.'/../../public/'.$path;

        if (!file_exists($file)) {
            return '';
        }

        $svg = file_get_contents($file);

        if (!$svg) {
            return '';
        }

        if ($classes) {
            /** @var string $svg */
            $svg = preg_replace('/<svg([^>]*?)\sclass="[^"]*"/i', '<svg$1', $svg);
            $svg = preg_replace('/<svg([^>]*)>/i', '<svg$1 class="'.htmlspecialchars($classes, ENT_QUOTES).'">', $svg, 1);
        }

        return (string) $svg;
    }

    /** @return array<string, string> */
    public function getMeta(): array
    {
        return $this->settingManager->getMeta();
    }

    /** @return array<int, mixed> */
    public function getMenuCategories(): array
    {
        return $this->settingManager->getShopCategories();
    }

    public function getCart(): ?Cart
    {
        $cookie = $this->cookieManager->get(CookieName::SHOP_CART->value);
        if (!$cookie) {
            return null;
        }

        return $this->entityManager->getRepository(Cart::class)->findOneBy(['token' => $cookie]);
    }
}
