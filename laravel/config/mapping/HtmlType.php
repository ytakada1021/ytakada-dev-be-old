<?php

declare(strict_types=1);

namespace Mapping;

use App\Command\Models\Common\Html;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class HtmlType extends Type
{
    const TYPE = 'html';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'html';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        } else {
            return $value->value;
        }
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        } else {
            return new Html($value);
        }
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
