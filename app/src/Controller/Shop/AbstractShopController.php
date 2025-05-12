<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use App\Interfaces\ActivatableInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractShopController extends AbstractController
{
    public function __construct(
        protected readonly TranslatorInterface $translator,
    )
    {
    }

    public function ensurePageIsActive(ActivatableInterface $entity): void
    {
        if (!$entity->isActive()) {
            throw $this->createNotFoundException($this->translator->trans('shop.errors.not_found'));
        }
    }
}
