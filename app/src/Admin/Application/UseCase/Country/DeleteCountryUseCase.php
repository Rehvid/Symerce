<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Country;

use App\Admin\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteCountryUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository
    ) {}


    public function execute(int|string $entityId): void
    {
        $country = $this->countryRepository->findById($entityId);
        if (null === $country) {
            throw new EntityNotFoundException();
        }

        $this->countryRepository->remove($country);
    }
}
