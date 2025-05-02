<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractApiController;
use App\DTO\Request\PersistableInterface;
use App\Interfaces\IdentifiableEntityInterface;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Mapper\Manager\ManagerMapperResponse;
use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\PaginationRepositoryInterface;
use App\Service\DataPersister\Manager\PersisterManager;
use App\Service\Pagination\PaginationResponse;
use App\Service\Pagination\PaginationService;
use App\Service\RequestDtoResolver;
use App\Service\Response\ResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractCrudAdminController extends AbstractApiController
{

    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        protected readonly RequestDtoResolver $requestDtoResolver,
        protected readonly PaginationService $paginationService,
        protected readonly ManagerMapperResponse $managerMapperResponse,
        PersisterManager $dataPersisterManager,
        TranslatorInterface $translator,
        ResponseService $responseService,
    ) {
        parent::__construct($dataPersisterManager, $translator, $responseService);
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse($request, $this->getRepository());

        return $this->prepareJsonResponse(
            data: $this->getResponseMapper()->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    #[Route('', name: 'store', methods: ['POST'], format: 'json')]
    public function store(Request $request): JsonResponse
    {
        $persistable = $this->requestDtoResolver->mapAndValidate($request, $this->getStoreDtoClass());

        $entityStored = $this->dataPersisterManager->persist($persistable);
        if ($entityStored instanceof IdentifiableEntityInterface) {
            return $this->prepareJsonResponse(
                data: ['id' => $entityStored->getId()],
                message: $this->translator->trans('base.messages.store'),
                statusCode: Response::HTTP_CREATED
            );
        }

        throw new \LogicException('Persisted entity does not implement IdentifiableEntityInterface');
    }

    #[Route('/{id}/form-data', name: 'update_form_data', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showUpdateFormData(string|int $id): JsonResponse
    {
        /** @var object $entity */
        $entity = $this->getEntity($id);

        return $this->prepareJsonResponse(
            data: $this->getResponseMapper()->mapToUpdateFormDataResponse(['entity' => $entity])
        );
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function update(Request $request, string|int $id): JsonResponse
    {
        /** @var object $entity */
        $entity = $this->getEntity($id);

        $persistable = $this->requestDtoResolver->mapAndValidate($request, $this->getUpdateDtoClass());

        $entityUpdated = $this->dataPersisterManager->update($persistable, $entity);
        if ($entityUpdated instanceof IdentifiableEntityInterface) {
            return $this->prepareJsonResponse(
                data: ['id' => $entityUpdated->getId()],
                message: $this->translator->trans('base.messages.update')
            );
        }

        throw new \LogicException('Persisted entity does not implement IdentifiableEntityInterface');
    }

    #[Route('/{id}', name: 'destroy', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function destroy(string|int $id): JsonResponse
    {
        /** @var object $entity */
        $entity = $this->getEntity($id);

        $this->dataPersisterManager->delete($entity);

        return $this->prepareJsonResponse(message: $this->translator->trans('base.messages.destroy'));
    }

    private function getEntity(string|int $id): object
    {
        $entity = $this->getRepository()->find($id);

        if (null === $entity) {
            throw $this->createNotFoundException($this->translator->trans('base.messages.errors.not_found'));
        }

        return $entity;
    }

    /** @param array<string,mixed> $additionalData */
    protected function getPaginatedResponse(
        Request $request,
        PaginationRepositoryInterface $paginationRepository,
        array $additionalData = []
    ): PaginationResponse {
        return $this->paginationService->buildPaginationResponse($request, $paginationRepository, $additionalData);
    }

    /** @param class-string<object> $class  */
    protected function getRepositoryInstanceForClass(string $class): AbstractRepository
    {
        $repository = $this->entityManager->getRepository($class);

        if (!($repository instanceof AbstractRepository)) {
            throw $this->createNotFoundException($this->translator->trans('base.messages.errors.not_found'));
        }

        return $repository;
    }

    /** @return class-string<PersistableInterface> */
    abstract protected function getUpdateDtoClass(): string;

    /** @return class-string<PersistableInterface> */
    abstract protected function getStoreDtoClass(): string;

    abstract protected function getResponseMapper(): ResponseMapperInterface;

    abstract protected function getRepository(): AbstractRepository;
}
