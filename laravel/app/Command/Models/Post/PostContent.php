<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use App\Command\Models\Common\Html;

final class PostContent
{
    public function __construct(public readonly Html $value) {}
}
