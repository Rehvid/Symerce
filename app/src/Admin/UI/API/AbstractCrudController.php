<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\UseCase\Base\CreateUseCaseInterface;
use App\Admin\Application\UseCase\Base\DeleteUseCaseInterface;
use App\Admin\Application\UseCase\Base\GetByIdUseCaseInterface;
use App\Admin\Application\UseCase\Base\ListUseCaseInterface;
use App\Admin\Application\UseCase\Base\UpdateUseCaseInterface;

abstract class AbstractCrudController
{
    abstract protected function getListUseCase(): ListUseCaseInterface;
    abstract protected function getGetByIdUseCase(): GetByIdUseCaseInterface;
    abstract protected function getCreateUseCase(): CreateUseCaseInterface;
    abstract protected function getUpdateUseCase(): UpdateUseCaseInterface;
    abstract protected function getDeleteUseCase(): DeleteUseCaseInterface;
}
