<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use Stringable;
use Util\Assert;

final class TagId implements Stringable
{
    private readonly string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'Argument cannot be empty string.');
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
