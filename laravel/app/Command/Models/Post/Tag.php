<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use Util\Assert;

final class Tag
{
    private TagId $id;

    public function __construct(TagId $id)
    {
        $this->id = $id;
    }

    public function id(): TagId
    {
        return $this->id;
    }
}
