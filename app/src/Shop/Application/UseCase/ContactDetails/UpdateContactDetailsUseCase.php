<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\ContactDetails;

use App\Shop\Application\DTO\Request\ContactDetails\SaveContactDetailsRequest;
use App\Shop\Application\Hydrator\ContactDetailsHydrator;
use App\Shop\Domain\Entity\Embeddables\ContactDetails;

final readonly class UpdateContactDetailsUseCase
{
    public function __construct(
        private ContactDetailsHydrator $contactDetailsHydrator,
    ) {
    }

    public function execute(SaveContactDetailsRequest $request, ContactDetails $contactDetails): ContactDetails
    {

        return $this->contactDetailsHydrator->hydrate($request, $contactDetails);
    }
}
