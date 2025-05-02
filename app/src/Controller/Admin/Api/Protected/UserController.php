<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Request\User\SaveUserRequestDTO;
use App\Entity\User;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Mapper\UserResponseMapper;
use App\Repository\Base\AbstractRepository;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users', name: 'user_')]
class UserController extends AbstractCrudAdminController
{
    protected function getStoreDtoClass(): string
    {
        return SaveUserRequestDTO::class;
    }

    protected function getUpdateDtoClass(): string
    {
        return SaveUserRequestDTO::class;
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(User::class);
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(UserResponseMapper::class);
    }
}
