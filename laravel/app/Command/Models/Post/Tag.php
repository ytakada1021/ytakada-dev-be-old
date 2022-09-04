<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use Util\Assert;

final class Tag
{
    private readonly string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'Argument cannot be empty string.');
        $this->vablue = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
