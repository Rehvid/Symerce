<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Tag\SaveTagRequest;
use App\Admin\Application\UseCase\Tag\CreateTagUseCase;
use App\Admin\Application\UseCase\Tag\DeleteTagUseCase;
use App\Admin\Application\UseCase\Tag\GetByIdTagUseCase;
use App\Admin\Application\UseCase\Tag\ListTagUseCase;
use App\Admin\Application\UseCase\Tag\UpdateTagUseCase;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/tags', name: 'tag_')]
final class TagController extends AbstractCrudController
{
    public function __construct(
        private readonly CreateTagUseCase $createTagUseCase,
        private readonly UpdateTagUseCase $updateTagUseCase,
        private readonly DeleteTagUseCase $deleteTagUseCase,
        private readonly ListTagUseCase $listTagUseCase,
        private readonly GetByIdTagUseCase $getByIdTagUseCase,
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveTagRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveTagRequest::class;
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listTagUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdTagUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createTagUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateTagUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteTagUseCase;
    }
}
