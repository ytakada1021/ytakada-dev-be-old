<?php

declare(strict_types=1);

namespace Util;

final class StringUtil
{
    public static function mbTrim(string $str): string
    {
        return preg_replace('/\A[\p{Cc}\p{Cf}\p{Z}]++|[\p{Cc}\p{Cf}\p{Z}]++\z/u', '', $str);
    }
}
