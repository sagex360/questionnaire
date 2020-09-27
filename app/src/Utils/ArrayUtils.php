<?php

namespace App\Utils;

class ArrayUtils
{
    public static function isAssocArray(array $array): bool
    {
        if (empty($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }

    public static function getFirstStringKeyInAssocArray(array $array): ?string
    {
        foreach ($array as $key => $value) {
            if (is_string($key)) {
                return $key;
            }
        }

        return null;
    }
}
