<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use App\DTO\Shop\Response\Category\CategoryIndexResponseDTO;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\FileService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly FileService $fileService,
    ) {
    }

    #[Route('/kategorie', name: 'shop.categories', methods: ['GET'])]
    public function index(): Response
    {
        $categories = $this->categoryRepository->findBy(['isActive' => true], ['order' => 'ASC']);

        $data = array_map(function (Category $category) {
            return CategoryIndexResponseDTO::fromArray([
                'name' => $category->getName(),
                'slug' => $category->getSlug(),
                'productCount' => $category->getProducts()->count(),
                'imagePath' => $this->fileService->preparePublicPathToFile($category->getImage()?->getPath()),
            ]);
        }, $categories);

        return $this->render('shop/category/index.html.twig', [
            'categories' => $data
        ]);
    }

    #[Route('/kategoria/{slug}', name: 'shop.category_show', methods: ['GET'])]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Category $category): Response
    {
        return $this->render('shop/category/show.html.twig', [
            'category' => $category
        ]);
    }
}
