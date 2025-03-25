<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api;

use App\Service\CategoryTreeBuilder;
use App\Service\PaginatedListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/category', name: 'api_category_')]
class CategoryController extends AbstractController
{

    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getList(Request $request, PaginatedListService $paginatedListService): JsonResponse
    {
        return $this->json($paginatedListService->getListResponse($request));
    }

    #[Route('/form-data', name: 'form_data', methods: ['GET'])]
    public function getFormData(CategoryTreeBuilder $treeBuilder): JsonResponse
    {
        return $this->json($treeBuilder->generateTree());
    }
}
