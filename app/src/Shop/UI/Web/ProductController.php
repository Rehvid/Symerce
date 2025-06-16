<?php

declare(strict_types=1);

namespace App\Shop\UI\Web;

use App\Common\Domain\Entity\Product;
use App\Shop\Application\UseCase\Product\GetByIdProductUseCase;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/kategoria/{slugCategory}/produkt/{slug}', name: 'shop.product_show', methods: ['GET'])]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Product $product,
        GetByIdProductUseCase $useCase,
    ): Response {
        return $this->render('shop/product/show.html.twig', $useCase->execute($product));
    }
}
