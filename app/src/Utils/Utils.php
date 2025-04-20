<?php

namespace App\Utils;

class Utils
{
    /**
     * @param array <string, mixed> $items
     *
     * @return array<int, mixed>
     */
    public static function buildSelectedOptions(
        array $items,
        callable $labelCallback,
        callable $valueCallback
    ): array {
        $result = [];
        $iterator = 0;
        foreach ($items as $item) {
            $result[$iterator++] = [
                'label' => $labelCallback($item),
                'value' => $valueCallback($item),
            ];
        }

        return $result;
    }
}
