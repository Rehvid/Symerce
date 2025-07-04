<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Twig;

use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Common\Application\Service\SettingsService;
use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Enums\CookieName;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(
        private readonly SettingsService $settingManager,
        private readonly  RequestStack $requestStack,
        private readonly CartRepositoryInterface $cartRepository,
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
        $cookie = $this->requestStack->getCurrentRequest()?->cookies->get(CookieName::SHOP_CART->value);
        if (!$cookie) {
            return null;
        }

        return $this->cartRepository->findByToken($cookie);
    }
}
