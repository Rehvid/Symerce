<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Setting;

use App\Admin\Application\Hydrator\SettingHydrator;
use App\Admin\Domain\Repository\SettingRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateSettingUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private SettingRepositoryInterface $repository,
        private SettingHydrator $hydrator
    ) {
    }

    public function execute(RequestDtoInterface $requestDto, int|string $entityId): array
    {
        $setting = $this->repository->findById($entityId);
        if (null === $setting) {
            throw new EntityNotFoundException();
        }
        $this->hydrator->hydrate($requestDto, $setting);
        $this->repository->save($setting);

        return (new IdResponse($setting->getId()))->toArray();
    }
}
