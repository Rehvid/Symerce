<?php

declare(strict_types=1);

namespace App\Mapper\Interfaces;

interface ResponseMapperInterface
{
    /**
     * @param array<int, mixed> $data
     *
     * @return array<int, mixed>
     */
    public function mapToIndexResponse(array $data = []): array;

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function mapToUpdateFormDataResponse(array $data = []): array;
}
