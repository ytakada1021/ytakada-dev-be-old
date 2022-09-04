<?php

declare(strict_types=1);

namespace Util;

use InvalidArgumentException;

final class Assert
{
    public static function notEmpty(string $str, string $message): void
    {
        if (StringUtil::mbTrim($str) === '') {
            throw new InvalidArgumentException($message);
        }
    }

    public static function arrayOfClass(array $arr, string $className, string $message): void
    {
        foreach ($arr as $item) {
            if ($item::class !== $className) {
                throw new InvalidArgumentException($message);
            }
        }
    }
}
