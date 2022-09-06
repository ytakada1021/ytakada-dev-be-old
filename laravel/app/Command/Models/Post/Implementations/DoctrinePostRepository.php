<?php

declare(strict_types=1);

namespace App\Command\Models\Post\Implementations;

use App\Command\Models\Post\Post;
use App\Command\Models\Post\PostId;
use App\Command\Models\Post\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrinePostRepository implements PostRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postOfId(PostId $postId): ?Post
    {
        return $this->entityManager->find(Post::class, $postId);
    }

    public function save(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function delete(PostId $postId): void
    {
        /** @var ?Post $post */
        $post = $this->postOfId($postId);

        if (!is_null($post)) {
            $this->entityManager->remove($post);
            $this->entityManager->flush();
        }
    }
}
