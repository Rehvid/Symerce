<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Admin\Request\Setting\SaveSettingRequestDTO;
use App\Entity\Setting;
use App\Mapper\Admin\SettingResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/settings', name: 'setting_')]
class SettingsController extends AbstractCrudAdminController
{
    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function showStoreFormData(): JsonResponse
    {
        /** @var SettingResponseMapper $responseMapper */
        $responseMapper = $this->getResponseMapper();

        return $this->prepareJsonResponse(
            data: $responseMapper->mapToStoreFormDataResponse(),
        );
    }

    protected function getUpdateDtoClass(): string
    {
        return SaveSettingRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveSettingRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(SettingResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(Setting::class);
    }
}
