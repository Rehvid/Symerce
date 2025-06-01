<?php

declare (strict_types=1);

namespace App\Admin\Application\UseCase\Profile;

use App\Admin\Application\Assembler\ProfileAssembler;
use App\Admin\Application\DTO\Request\Profile\UpdatePersonalRequest;
use App\Admin\Application\Hydrator\ProfilePersonalHydrator;
use App\Admin\Domain\Repository\UserRepositoryInterface;
use App\Common\Domain\Entity\User;

final readonly class UpdatePersonalUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private ProfilePersonalHydrator $hydrator,
        private ProfileAssembler $assembler,
    ) {

    }

    public function execute(UpdatePersonalRequest $requestDto, User $user): array
    {
        $this->hydrator->hydrate($requestDto, $user);
        $this->repository->save($user);

        return $this->assembler->toPersonalResponse($user);
    }
}
