<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\Admin\Application\Hydrator\ProfilePersonalHydrator;
use App\Admin\Application\Service\FileService;
use App\Common\Domain\Entity\User;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Application\Assembler\ProfileAssembler;
use App\User\Application\Command\UpdateUserProfilePersonalCommand;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class UpdateUserProfilePersonalCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private FileService $fileService,
        private ProfileAssembler $assembler,
    ) {}

    public function __invoke(UpdateUserProfilePersonalCommand $command): array
    {
        /** @var ?User $user */
        $user = $this->repository->findById($command->userId);
        if (null === $user) {
            throw EntityNotFoundException::for(User::class, $command->userId);
        }
        $data = $command->data;

        $user->setEmail($data->email);
        $user->setFirstname($data->firstname);
        $user->setSurname($data->surname);

        if ($data->fileData) {
            $this->fileService->replaceFile($user, $data->fileData);
        }

        $this->repository->save($user);

        return $this->assembler->toPersonalResponse($user);
    }
}
