<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

final class Content
{
    private readonly Html $value;

    private function __construct(Html $value)
    {
        $this->value = $value;
    }

    public function value(): Html
    {
        return $this->value;
    }
}
