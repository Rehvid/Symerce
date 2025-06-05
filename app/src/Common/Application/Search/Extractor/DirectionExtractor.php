<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Extractor;

use App\Common\Domain\Enums\DirectionType;
use Symfony\Component\HttpFoundation\Request;

final readonly class DirectionExtractor
{
    public function extract(Request $request): ?DirectionType
    {
        $direction = $request->query->get('direction');
        if (null === $direction) {
            return null;
        }

        return DirectionType::tryFrom($direction);
    }
}
