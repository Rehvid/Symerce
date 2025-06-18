<?php

declare(strict_types=1);

namespace App\Category\Ui\Web\Shop;

use App\Category\Application\Query\Shop\GetCategoryBySlugQuery;
use App\Category\Application\Query\Shop\GetCategoryListQuery;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Common\Infrastructure\Bus\Query\QueryBusInterface;
use App\Shop\Application\UseCase\Category\GetByIdCategoryUseCase;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/kategorie', name: 'shop.categories', methods: ['GET'])]
    public function list(QueryBusInterface $queryBus): Response
    {
        return $this->render('shop/category/index.html.twig', [
            'data' => $queryBus->ask(new GetCategoryListQuery())
        ]);
    }

    #[Route('/kategoria/{slug}', name: 'shop.category_show', methods: ['GET'])]
    public function show(string $slug, QueryBusInterface $queryBus): Response
    {
        try {
            $data = $queryBus->ask(new GetCategoryBySlugQuery($slug));
        } catch (\Throwable) {
            return $this->redirectToRoute('shop.categories');
        }


        return $this->render('shop/category/show.html.twig', [
            'data' => $data,
        ]);
    }
}
