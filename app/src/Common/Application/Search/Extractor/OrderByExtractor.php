<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Extractor;

use Symfony\Component\HttpFoundation\Request;

final readonly class OrderByExtractor
{
    private const string ORDER_BY_FIELD_SEPARATOR = '.';

    public function extract(Request $request, array $allowedSortFields): ?string
    {
        $orderBy = $request->query->get('orderBy');

        if (null === $orderBy) {
            return null;
        }

        $orderByField = explode(self::ORDER_BY_FIELD_SEPARATOR, $orderBy);
        $field = $orderByField[0] ?? null;

        if (!in_array($field, $allowedSortFields, true)) {
            return null;
        }

        return $field;
    }
}
