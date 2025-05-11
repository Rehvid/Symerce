<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/kategoria/{slugCategory}/produkt/{slug}', name: 'shop.product_show', methods: ['GET'])]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Product $product
    ): Response
    {
        return $this->render('shop/product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
