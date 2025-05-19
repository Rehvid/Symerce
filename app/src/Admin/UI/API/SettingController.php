<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Setting\SaveSettingRequest;
use App\Admin\Application\UseCase\Setting\CreateSettingUseCase;
use App\Admin\Application\UseCase\Setting\DeleteSettingUseCase;
use App\Admin\Application\UseCase\Setting\GetByIdSettingUseCase;
use App\Admin\Application\UseCase\Setting\GetSettingCreateDataUseCase;
use App\Admin\Application\UseCase\Setting\ListSettingUseCase;
use App\Admin\Application\UseCase\Setting\UpdateSettingUseCase;
use App\Service\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/settings', name: 'setting_')]
final class SettingController extends AbstractCrudController
{

    public function __construct(
        private readonly CreateSettingUseCase $createSettingUseCase,
        private readonly UpdateSettingUseCase $updateSettingUseCase,
        private readonly DeleteSettingUseCase $deleteSettingUseCase,
        private readonly ListSettingUseCase $listSettingUseCase,
        private readonly GetByIdSettingUseCase $getByIdSettingUseCase,
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(GetSettingCreateDataUseCase $useCase): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute()
            )
        );
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listSettingUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
       return $this->getByIdSettingUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createSettingUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateSettingUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteSettingUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveSettingRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveSettingRequest::class;
    }
}
