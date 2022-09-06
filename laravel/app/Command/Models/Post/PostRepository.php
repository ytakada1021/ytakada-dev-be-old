<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use App\Command\Models\Post\Exceptions\PostNotFoundException;

interface PostRepository
{
    /**
     * 指定されたIDのPostを取得する.
     * 見つからない場合はnullを返却する.
     * @param PostId $postId
     * @return ?Post
     */
    function postOfId(PostId $postId): ?Post;

    function save(Post $post): void;

    /**
     * 指定されたIDのPostを削除する.
     * @param PostId $postId
     * @throws PostNotFoundException
     */
    function delete(PostId $postId): void;
}
