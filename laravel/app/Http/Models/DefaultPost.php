<?php

declare(strict_types=1);

namespace App\Http\Models;

use App\Command\Models\Post\Post;

class DefaultPost
{
    public static function createFromDomainModel(Post $domainModel): self
    {
        return new self(
            $domainModel->id()->value(),
            $domainModel->title()->value(),
            $domainModel->content()->value()->value(),
            $domainModel->postedAt()->toIso8601String(),
            $domainModel->updatedAt()->toIso8601String()
        );
    }

    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $content,
        public readonly string $posted_at,
        public readonly string $updated_at
    ) {}
}
