<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use App\Command\Models\Common\Html;

final class Content
{
    private readonly Html $value;

    public function __construct(Html $value)
    {
        $this->value = $value;
    }

    public function value(): Html
    {
        return $this->value;
    }
}
