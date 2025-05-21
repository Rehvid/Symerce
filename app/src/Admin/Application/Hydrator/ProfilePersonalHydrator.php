<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Profile\UpdatePersonalRequest;
use App\Admin\Application\Service\FileService;
use App\Admin\Domain\Entity\User;

final readonly class ProfilePersonalHydrator
{
    public function __construct(
        private FileService $fileService,
    ) {
    }

    public function hydrate(UpdatePersonalRequest $request, User $user): User
    {
        $user->setEmail($request->email);
        $user->setFirstname($request->firstname);
        $user->setSurname($request->surname);

        if ($request->fileData) {
            $this->fileService->replaceFile($user, $request->fileData);
        }

        return $user;
    }
}
