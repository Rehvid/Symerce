<?php

declare(strict_types=1);

namespace App\Setting\Application\Handler\Command;

use App\Setting\Application\Command\UpdateSettingCommand;
use App\Setting\Domain\Enums\SettingValueType;
use App\Setting\Domain\Repository\SettingRepositoryInterface;
use App\Setting\Domain\ValueObject\SettingValueVO;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;


final readonly class UpdateSettingCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SettingRepositoryInterface $repository,
    ) {}

    public function __invoke(UpdateSettingCommand $command): IdResponse
    {
        $settingData = $command->settingData;

        $settingValueVO = new SettingValueVO(
            SettingValueType::from($settingData->settingValueType),
            $settingData->value
        );

        $setting = $settingData->setting;
        $setting->setActive($settingData->isActive);
        $setting->setName($settingData->name);
        $setting->setValue($settingValueVO->getRawValue());

        $this->repository->save($setting);

        return new IdResponse($setting->getId());
    }
}
