<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

interface PostRepository
{
    function postOfId(PostId $postId): ?Post;

    function save(Post $post): void;

    function delete(PostId $postId): void;
}
