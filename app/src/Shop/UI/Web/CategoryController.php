<?php

declare(strict_types=1);

namespace App\Shop\UI\Web;

use App\Admin\Domain\Entity\Category;
use App\Shop\Application\UseCase\Category\GetByIdCategoryUseCase;
use App\Shop\Application\UseCase\Category\ListCategoryUseCase;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{

    #[Route('/kategorie', name: 'shop.categories', methods: ['GET'])]
    public function list(ListCategoryUseCase $useCase): Response
    {
        return $this->render('shop/category/index.html.twig', $useCase->execute());
    }

    #[Route('/kategoria/{slug}', name: 'shop.category_show', methods: ['GET'])]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Category $category,
        GetByIdCategoryUseCase $useCase
    ): Response {
        return $this->render('shop/category/show.html.twig', $useCase->execute($category));
    }
}
