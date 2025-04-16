<?php

namespace App\Utils;

class Utils
{
    public static function buildTranslatedOptions(
        array $items,
        callable $labelCallback,
        callable $valueCallback
    ): array
    {
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
