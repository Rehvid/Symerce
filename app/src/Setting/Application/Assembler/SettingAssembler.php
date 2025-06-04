<?php

declare(strict_types=1);

namespace App\Setting\Application\Assembler;

use App\Common\Application\Assembler\ResponseHelperAssembler;
use App\Common\Domain\Entity\Setting;
use App\Setting\Application\Dto\Response\SettingFormResponse;
use App\Setting\Application\Dto\Response\SettingListResponse;
use App\Setting\Application\Factory\SettingFieldFactory;

final readonly class SettingAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private SettingFieldFactory $settingFieldFactory,
    ) {
    }

    public function toListResponse(array $paginatedData): array
    {
        $dataList = array_map(
            fn (Setting $setting) => $this->createSettingListResponse($setting),
            $paginatedData
        );

        return $this->responseHelperAssembler->wrapListWithAdditionalData($dataList);
    }

    public function toFormDataResponse(Setting $setting): array
    {
        return $this->responseHelperAssembler->wrapFormResponse(
            new SettingFormResponse(
                settingField: $this->settingFieldFactory->create($setting),
                isActive: $setting->isActive(),
                name: $setting->getName(),
            ),
        );
    }

    private function createSettingListResponse(Setting $setting): SettingListResponse
    {
        return new SettingListResponse(
            id: $setting->getId(),
            name: $setting->getName(),
            type: $setting->getType()->value,
            isActive: $setting->isActive(),
        );
    }
}
