<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/kategorie', name: 'shop.categories', methods: ['GET'])]
    public function index()
    {
        dd('kategories');
    }

    #[Route('/kategoria/{slug}', name: 'shop.category_show', methods: ['GET'])]
    public function show(string $slug)
    {
        return dd($slug);
    }
}
