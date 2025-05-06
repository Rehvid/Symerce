<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Admin\Request\Tag\SaveTagRequestDTO;
use App\Entity\Tag;
use App\Mapper\Admin\TagResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tags', name: 'tag_')]
class TagController extends AbstractCrudAdminController
{
    protected function getUpdateDtoClass(): string
    {
        return SaveTagRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveTagRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(TagResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(Tag::class);
    }
}
