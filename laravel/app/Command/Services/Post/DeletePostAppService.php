<?php

declare(strict_types=1);

namespace App\Command\Services\Post;

use App\Command\Models\Post\PostId;
use App\Command\Models\Post\PostRepository;
use App\Command\Services\Post\DeletePostAppService\Input;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final class DeletePostAppService
{
    private readonly PostRepository $postRepository;

    private readonly EntityManagerInterface $entityManager;

    public function __construct(
        PostRepository $postRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
    }

    public function execute(Input $input): void
    {
        $this->entityManager->beginTransaction();

        try {
            $this->postRepository->delete(new PostId($input->postId()));

            $this->entityManager->commit();
        } catch (Throwable $th) {
            $this->entityManager->rollback();
            throw $th;
        }
    }
}

namespace App\Command\Services\Post\DeletePostAppService;

final class Input
{
    private readonly string $postId;

    public function __construct(string $postId)
    {
        $this->postId = $postId;
    }

    public function postId(): string
    {
        return $this->postId;
    }
}
