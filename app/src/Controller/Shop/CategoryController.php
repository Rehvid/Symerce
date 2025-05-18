<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use App\Admin\Infrastructure\Repository\CategoryRepository;
use App\DTO\Shop\Response\Category\CategoryIndexResponseDTO;
use App\Entity\Category;
use App\Entity\Product;
use App\Service\FileService;
use App\Service\SettingManager;
use App\ValueObject\Money;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryController extends AbstractShopController
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly FileService $fileService,
        private readonly SettingManager $settingManager,
        TranslatorInterface $translator
    ) {
        parent::__construct($translator);
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
        $this->ensurePageIsActive($category);


        //TODO: Create responseMapper and DTO
        $subcategories = array_map(function (Category $category) {
            return [
                'name' => $category->getName(),
                'href' => $this->generateUrl('shop.category_show', ['slug' => $category->getSlug()]),
                'image' => $this->fileService->preparePublicPathToFile($category->getImage()?->getPath()),
            ];
        }, $category->getChildren()->toArray());

        $currency = $this->settingManager->findDefaultCurrency();

        $products = array_map(function (Product $product) use ($category, $currency) {
            $discountPrice = $product->getDiscountPrice() === null
                ? null
                : (new Money($product->getDiscountPrice(), $currency))->getFormattedAmountWithSymbol();

            return [
                'name' => $product->getName(),
                'url' => $this->generateUrl('shop.product_show', ['slugCategory' => $category->getSlug(),'slug' => $product->getSlug()]),
                'thumbnail' => $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile()?->getPath()),
                'discountPrice' => $discountPrice,
                'regularPrice' => (new Money($product->getRegularPrice(), $currency))->getFormattedAmountWithSymbol(),
                'hasPromotion' => $discountPrice !== null,
            ];
        }, $category->getProducts()->toArray());

        return $this->render('shop/category/show.html.twig', [
            'category' => $category,
            'subcategories' => $subcategories,
            'products' => $products,
        ]);
    }
}
