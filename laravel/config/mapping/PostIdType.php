<?php

declare(strict_types=1);

namespace Mapping;

use App\Command\Models\Post\PostId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class PostIdType extends Type
{
    const TYPE = 'post_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'post_id';
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
            return new PostId($value);
        }
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
