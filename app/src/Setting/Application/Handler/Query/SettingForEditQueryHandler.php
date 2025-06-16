<?php

declare(strict_types=1);

namespace App\Setting\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\Setting;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Setting\Application\Assembler\SettingAssembler;
use App\Setting\Application\Query\GetSettingForEditQuery;
use App\Setting\Domain\Repository\SettingRepositoryInterface;

final readonly class SettingForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SettingAssembler $assembler,
        private SettingRepositoryInterface $repository
    ) {
    }

    public function __invoke(GetSettingForEditQuery $query): array
    {
        /** @var ?Setting $setting */
        $setting = $this->repository->findById($query->settingId);
        if (null === $setting) {
            throw EntityNotFoundException::for(Setting::class, $query->settingId);
        }

        return $this->assembler->toFormDataResponse($setting);
    }
}
