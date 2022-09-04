<?php

declare(strict_types=1);

namespace App\Command\Models\Post\Implementations;

use App\Command\Models\Post\Id;
use App\Command\Models\Post\Post;
use App\Command\Models\Post\PostRepository;

final class DoctrinePostRepository implements PostRepository
{
    public function postOfId(Id $postId): ?Post
    {
        // TODO: 実装
        assert(false);
        return null;
    }

    public function save(Post $post): void
    {
        // TODO: 実装
        assert(false);
    }

    public function delete(Id $postId): void
    {
        // TODO: 実装
        assert(false);
    }
}
