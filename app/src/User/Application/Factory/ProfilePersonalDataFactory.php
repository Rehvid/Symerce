<?php

declare(strict_types=1);

namespace App\User\Application\Factory;

use App\User\Application\Dto\ProfilePersonalData;
use App\User\Application\Dto\Request\UpdatePersonalRequest;

final readonly class ProfilePersonalDataFactory
{
    public function fromRequest(UpdatePersonalRequest $request): ProfilePersonalData
    {
        return new ProfilePersonalData(
            firstname: $request->firstname,
            surname: $request->surname,
            email: $request->email,
            id: $request->id,
            fileData: $request->fileData,
        );
    }
}
