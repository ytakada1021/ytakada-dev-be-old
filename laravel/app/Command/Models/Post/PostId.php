<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use Stringable;
use Util\Assert;

final class PostId implements Stringable
{
    // 半角英数, -, _を含む50文字以内の文字列
    public const FORMAT = '/\A[0-9a-zA-Z\-\_]{1,50}\z/u';

    private readonly string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value, 'Argument cannot be empty string.');
        $this->value = $value;
    }

    /**
     * Doctrine ORマッピングのエンティティのIDとして使用するため実装する
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
