<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Setting;

use App\Admin\Application\Assembler\SettingAssembler;
use App\Admin\Domain\Repository\SettingRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdSettingUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private SettingRepositoryInterface $repository,
        private SettingAssembler          $assembler,
    ) {
    }


    public function execute(int|string $entityId): mixed
    {
        $setting = $this->repository->findById($entityId);
        if (null === $setting) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($setting);
    }
}
