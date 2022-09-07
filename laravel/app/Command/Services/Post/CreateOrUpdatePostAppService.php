<?php

declare(strict_types=1);

namespace App\Command\Services\Post;

use App\Command\Models\Common\MarkdownConverter;
use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use App\Command\Models\Post\Post;
use App\Command\Models\Post\PostId;
use App\Command\Models\Post\PostRepository;
use App\Command\Services\Post\CreatePostApplicationService\Input;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final class CreateOrUpdatePostAppService
{
    public function __construct(
        private PostRepository $postRepository,
        private MarkdownConverter $markdownConverter,
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * 記事IDに該当する記事が存在しない場合は新規作成し, すでに存在する場合は更新する.
     * 作成・更新されたオブジェクトをリポジトリに保存する.
     * @param Input $input
     * @return Post
     * @throws InvalidMarkdownException
     */
    public function execute(Input $input): Post
    {
        $this->entityManager->beginTransaction();

        try {
            $postId = new PostId($input->postId);

            /** @var ?Post $postOrNull */
            $postOrNull = $this->postRepository->postOfId($postId);

            /** @var Post $post */
            $post;

            if (is_null($postOrNull)) {
                $post = Post::createFromMarkdown(
                    $this->markdownConverter,
                    new PostId($input->postId),
                    $input->markdownText
                );

            } else {
                $post = $postOrNull;

                $post->updateFromMarkdown(
                    $this->markdownConverter,
                    $input->markdownText
                );
            }

            $this->postRepository->save($post);

            $this->entityManager->commit();

            return $post;

        } catch (Throwable $th) {
            $this->entityManager->rollback();
            throw $th;
        }
    }
}

namespace App\Command\Services\Post\CreatePostApplicationService;

final class Input
{
    public function __construct(
        public readonly string $postId,
        public readonly string $markdownText
    ) {
        $this->postId = $postId;
        $this->markdownText = $markdownText;
    }
}
