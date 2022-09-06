<?php

declare(strict_types=1);

namespace App\Command\Models\Post\Implementations;

use App\Command\Models\Post\{Id, Post, PostRepository};
use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrinePostRepository implements PostRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postOfId(Id $postId): ?Post
    {
        return $this->entityManager->find(Post::class, $postId);
    }

    public function save(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     *
     */
    public function delete(Id $postId): void
    {
        if (is_null($this->postOfId($postId))) {
            return;
        } else {
            $this
                ->entityManager
                ->getConnection()
                ->update(
                    table: 'posts',
                    data: [
                        'deleted_at',
                        CarbonImmutable::now()->toDateTimeString('microsecond')
                    ],
                    criteria: ['id', $postId->value()]
                );
        }
    }
}
