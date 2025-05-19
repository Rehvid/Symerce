<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Setting;

use App\Admin\Domain\Repository\SettingRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteSettingUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private SettingRepositoryInterface $repository,
    ) {
    }

    public function execute(int|string $entityId): void
    {
        $setting = $this->repository->findById($entityId);
        if ($setting === null) {
            throw new EntityNotFoundException();
        }

        $this->repository->remove($setting);
    }
}
