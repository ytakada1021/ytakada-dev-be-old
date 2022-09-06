<?php

declare(strict_types=1);

namespace App\Command\Services\Post;

use App\Command\Models\Common\MarkdownConverter;
use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use App\Command\Models\Post\Exceptions\PostAlreadyExistsException;
use App\Command\Models\Post\Post;
use App\Command\Models\Post\PostRepository;
use App\Command\Services\Post\CreatePostApplicationService\Input;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final class CreatePostAppService
{
    private readonly PostRepository $postRepository;

    private readonly MarkdownConverter $markdownConverter;

    private readonly EntityManagerInterface $entityManager;

    public function __construct(
        PostRepository $postRepository,
        MarkdownConverter $markdownConverter,
        EntityManagerInterface $entityManager
    )
    {
        $this->postRepository = $postRepository;
        $this->markdownConverter = $markdownConverter;
        $this->entityManager = $entityManager;
    }

    /**
     * Postクラスをインスタンス化し, リポジトリに保存し, 返却する.
     * @param Input $input
     * @return Post
     * @throws PostAlreadyExistsException
     * @throws InvalidMarkdownException
     */
    public function execute(Input $input): Post
    {
        $this->entityManager->beginTransaction();

        try {
            $post = Post::createFromMarkdown($this->markdownConverter, $input->markdownText());

            if (is_null($this->postRepository->postOfId($post->id()))) {
                $this->postRepository->save($post);

                return $post;
            } else {
                throw new PostAlreadyExistsException(
                    message: sprintf("Post of id '%s' already exists.",$post->id()->value())
                );
            }
        } catch (Throwable $th) {
            $this->entityManager->rollback();
            throw $th;
        }
    }
}

namespace App\Command\Services\Post\CreatePostApplicationService;

final class Input
{
    private readonly string $markdownText;

    public function __construct(string $markdownText)
    {
        $this->markdownText = $markdownText;
    }

    public function markdownText(): string
    {
        return $this->markdownText;
    }
}
