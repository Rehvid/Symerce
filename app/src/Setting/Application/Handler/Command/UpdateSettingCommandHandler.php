<?php

declare(strict_types=1);

namespace App\Setting\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Setting;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Setting\Application\Command\UpdateSettingCommand;
use App\Setting\Domain\Repository\SettingRepositoryInterface;


final readonly class UpdateSettingCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SettingRepositoryInterface $repository,
    ) {}

    public function __invoke(UpdateSettingCommand $command): IdResponse
    {
        $setting = $this->repository->findById($command->settingId);
        if (null === $setting) {
            throw EntityNotFoundException::for(Setting::class, $command->settingId);
        }

        $settingData = $command->data;

        $setting->setActive($settingData->isActive);
        $setting->setName($settingData->name);
        $setting->setValue($settingData->settingValueVO->getRawValue());

        $this->repository->save($setting);

        return new IdResponse($setting->getId());
    }
}
