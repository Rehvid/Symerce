<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Setting;

use App\Admin\Application\Hydrator\SettingHydrator;
use App\Admin\Domain\Entity\Setting;
use App\Admin\Domain\Repository\SettingRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateSettingUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private SettingRepositoryInterface $repository,
        private SettingHydrator $hydrator
    ) {

    }

    public function execute(RequestDtoInterface $requestDto): array
    {
        $setting = new Setting();
        $setting->setIsProtected(false);

        $this->hydrator->hydrate($requestDto, $setting);
        $this->repository->save($setting);

        return (new IdResponse($setting->getId()))->toArray();
    }
}
