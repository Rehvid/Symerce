<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Admin\Request\Vendor\SaveVendorRequestDTO;
use App\Entity\Vendor;
use App\Mapper\Admin\VendorResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vendors', name: 'vendor_')]
class VendorController extends AbstractCrudAdminController
{
    protected function getUpdateDtoClass(): string
    {
        return SaveVendorRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveVendorRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(VendorResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(Vendor::class);
    }
}
