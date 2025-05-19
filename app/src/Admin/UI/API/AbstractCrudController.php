<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractCrudController extends AbstractController
{
    public function __construct(
        protected readonly RequestDtoResolver $requestDtoResolver,
        protected readonly TranslatorInterface $translator,
    ) {
    }

    abstract protected function getListUseCase(): ListUseCaseInterface;
    abstract protected function getGetByIdUseCase(): GetByIdUseCaseInterface;
    abstract protected function getCreateUseCase(): CreateUseCaseInterface;
    abstract protected function getUpdateUseCase(): UpdateUseCaseInterface;
    abstract protected function getDeleteUseCase(): DeleteUseCaseInterface;

    abstract protected function getStoreRequestDtoClass(): string;

    abstract protected function getUpdateRequestDtoClass(): string;

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        return $this->json(
            data: $this->getListUseCase()->execute($request)
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $storeRequest = $this->requestDtoResolver->mapAndValidate($request, $this->getStoreRequestDtoClass());

        return $this->json(
            data: new ApiResponse(
                data: $this->getCreateUseCase()->execute($storeRequest),
                message: $this->translator->trans('base.messages.store')
            ),
            status: Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'], format: 'json')]
    public function update(Request $request, string|int $id): JsonResponse
    {
        $storeRequest = $this->requestDtoResolver->mapAndValidate($request, $this->getUpdateRequestDtoClass());

        return $this->json(
            data: new ApiResponse(
                data: $this->getUpdateUseCase()->execute($storeRequest, $id),
                message: $this->translator->trans('base.messages.update')
            )
        );
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(string|int $id): JsonResponse
    {

        return $this->json(
            data: new ApiResponse(data: $this->getGetByIdUseCase()->execute($id)),
        );
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(string|int $id): JsonResponse
    {
        $this->getDeleteUseCase()->execute($id);

        return $this->json(
            data: new ApiResponse(message: $this->translator->trans('base.messages.destroy'))
        );
    }
}
