<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Request\Currency\SaveCurrencyRequestDTO;
use App\Entity\Currency;
use App\Mapper\CurrencyResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/currencies', name: 'currency_')]
class CurrencyController extends AbstractCrudAdminController
{

    protected function getUpdateDtoClass(): string
    {
        return SaveCurrencyRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveCurrencyRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(CurrencyResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(Currency::class);
    }
}
