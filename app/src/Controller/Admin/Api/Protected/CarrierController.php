<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Admin\Request\Carrier\SaveCarrierRequestDTO;
use App\Entity\Carrier;
use App\Mapper\Admin\CarrierResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/carriers', name: 'carrier_')]
class CarrierController extends AbstractCrudAdminController
{
    protected function getUpdateDtoClass(): string
    {
        return SaveCarrierRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveCarrierRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(CarrierResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(Carrier::class);
    }
}
