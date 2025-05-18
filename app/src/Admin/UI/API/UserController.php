<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\User\SaveUseRequest;
use App\Admin\Application\UseCase\User\CreateUserUseCase;
use App\Admin\Application\UseCase\User\DeleteUserUseCase;
use App\Admin\Application\UseCase\User\GetByIdUserUseCase;
use App\Admin\Application\UseCase\User\GetUserCreateDataUseCase;
use App\Admin\Application\UseCase\User\ListUserUseCase;
use App\Admin\Application\UseCase\User\UpdateUserUseCase;
use App\Service\RequestDtoResolver;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/users', name: 'user_')]
final class UserController extends AbstractCrudController
{
    public function __construct(
        private readonly CreateUserUseCase $createUserUseCase,
        private readonly UpdateUserUseCase $updateUserUseCase,
        private readonly DeleteUserUseCase $deleteUserUseCase,
        private readonly ListUserUseCase $listUserUseCase,
        private readonly GetByIdUserUseCase $getByIdUserUseCase,
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(GetUserCreateDataUseCase $useCase): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute()
            )
        );
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveUseRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveUseRequest::class;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createUserUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateUserUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteUserUseCase;
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listUserUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdUserUseCase;
    }
}
