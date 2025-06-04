<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Cart\Web;

use App\Cart\Domain\Repository\CartRepositoryInterface;
use App\Shared\Domain\Enums\CookieName;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class GetByCookieCartUseCase
{
    public function __construct(
        private TranslatorInterface   $translator,
        private CartRepositoryInterface $repository,
    ) {}

    public function execute(Request $request): array
    {
        $cart = $this->repository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));
        if (!$cart) {
            throw new NotFoundHttpException($this->translator->trans('message.error.not_found'));
        }

        return [
            'cart' => $cart
        ];
    }
}
