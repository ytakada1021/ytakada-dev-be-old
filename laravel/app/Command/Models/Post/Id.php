<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use Stringable;
use Util\Assert;

final class Id implements Stringable
{
    private readonly string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'Argument cannot be empty string.');
        $this->value = $value;
    }

    /**
     * Doctrine ORマッピングのエンティティのIDとして使用されるクラスは`__toString()`メソッドを実装する必要あり.
     * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/cookbook/custom-mapping-types.html#custom-mapping-types
     */
    public function __toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
