<?php

declare(strict_types=1);

namespace Mapping;

use App\Command\Models\Post\TagId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class TagIdType extends Type
{
    const TYPE = 'tag_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'tag_id';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        } else {
            return $value->value();
        }
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        } else {
            return new TagId($value);
        }
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
