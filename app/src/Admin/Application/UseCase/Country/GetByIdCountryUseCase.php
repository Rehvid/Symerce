<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Country;

use App\Admin\Application\Assembler\CountryAssembler;
use App\Admin\Domain\Repository\CountryRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdCountryUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
        private CountryAssembler $assembler
    ) {}


    public function execute(int|string $entityId): mixed
    {
        $country = $this->countryRepository->findById($entityId);
        if (null === $country) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormResponse($country);
    }
}
